<?php
/*
 * *
 *  * This code is licensed under the MIT License.
 *  *
 *  * Copyright (c) 2022 Denis Potapov (https://yooogi.ru)
 *  *
 *  * Permission is hereby granted, free of charge, to any person obtaining a copy
 *  * of this software and associated documentation files (the "Software"), to deal
 *  * in the Software without restriction, including without limitation the rights
 *  * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  * copies of the Software, and to permit persons to whom the Software is
 *  * furnished to do so, subject to the following conditions:
 *  *
 *  * The above copyright notice and this permission notice shall be included in
 *  * all copies or substantial portions of the Software.
 *  *
 *  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  * THE SOFTWARE.
 *
 */

declare(strict_types=1);

namespace Yooogi\DellinSDK\Collections;

use Yooogi\DellinSDK\Endpoints\Calculations\Exceptions\CompatibleException;
use Yooogi\DellinSDK\Enum\PackageType;
use Yooogi\DellinSDK\Enum\PayerType;
use function func_get_args;

class PackageCollection extends Collection
{

	public array $quantities = [];
	public array $payers = [];
	/**
	 * Несовместимые упаковки по типам
	 *
	 * @var array|string[][]
	 */
	protected array $incompatible = [
		'0xA6A7BD2BF950E67F4B2CF7CC3A97C111' => ['0xB26E3AE60BF5FB6646363AFC69A10819',
			'0xb9f594d27a2d31b440a647d19547543c'],
		'0xB26E3AE60BF5FB6646363AFC69A10819' => ['0xA6A7BD2BF950E67F4B2CF7CC3A97C111'],
		'0xAE2EEA993230333043E719D4965D5D31' => ['0x84f7578779ae4a444e3dfc8b96d80e08'],
		'0xad97901b0ecef0f211e889fcf4624fec' => ['0xb9f594d27a2d31b440a647d19547543c'],
		'0xad97901b0ecef0f211e889fcf4624fed' => ['0xad97901b0ecef0f211e889fcf4624fea'],
		'0xad97901b0ecef0f211e889fcf4624fea' => ['0xad97901b0ecef0f211e889fcf4624fed'],
		'0xad97901b0ecef0f211e889fcf4624feb' => ['0x9195b45e731fd4bd44c3157f2e23b33f'],
		'0xA0A820F33B2F93FE44C8058B65C77D0F' => ['0x9195b45e731fd4bd44c3157f2e23b33f']
	];
	private array $packages = [];

	/**
	 * Коллекцию упаковок
	 *
	 * @param PackageType[] $packages ;
	 */

	public function __construct(array $packages = [], int $flags = 0, string $iteratorClass = "ArrayIterator")
	{
		$this->packages = $packages;

		if ($this->validate($this->packages)) {
			parent::__construct($this->packages, $flags, $iteratorClass);
		} else {

			$message = $this->getExceptionMessage();
			throw new CompatibleException('Несовместимые типы упаковки. ' . $message);

		}

	}

	/**
	 * Создать коллекцию из одной упаковки
	 *
	 * @param PackageType $package Тип упаковки;
	 */


	public static function one(object $package, int $flags = 0, string $iteratorClass = 'ArrayIterator'): self
	{
		return new self([$package], $flags, $iteratorClass);

	}

	/**
	 * Коллекция упаковок
	 *
	 * @param PackageType[] $packages Тип упаковки;
	 */


	public static function create(array $packages = [], int $flags = 0, string $iteratorClass = 'ArrayIterator'): self
	{
		return new self(...func_get_args());

	}

	public static function renderPackages(PackageCollection $packageCollection)
	{
		$packages = [];
		foreach ($packageCollection as $package) {
			if ($package instanceof PackageType) {
				$item['uid'] = $package->value;
				$item['count'] = $packageCollection->getQuantity($package) ?? 1;
				if ($packageCollection->getPayer($package)?->value) {
					$item['payer'] = $packageCollection->getPayer($package)->value;
				}
				$packages[] = $item;
			}
		}
		return $packages;
	}

	/**
	 * Получить количество по типам упаковок
	 *
	 * @param PackageType $type
	 *
	 * @return int|null
	 */
	public function getQuantity(PackageType $type): ?int
	{
		return ($this->quantities[$type->value]) ?? null;
	}

	/**
	 * Получить плательщика по упаковки
	 *
	 * @param PackageType $type
	 *
	 * @return PayerType|null
	 */
	public function getPayer(PackageType $type): ?PayerType
	{
		return ($this->payers[$type->value]) ?? null;
	}

	/**
	 * Добавить тип упаковки в коллекцию
	 *
	 * @param PackageType $package
	 *
	 * @return PackageCollection|null
	 */
	public function addPackage(PackageType $package): ?PackageCollection
	{

		$this->packages[] = $package;
		if ($this->validate($this->packages)) {
			$this->append($package);
			return $this;
		}

		$message = $this->getExceptionMessage();
		throw new CompatibleException('Несовместимые типы упаковки. ' . $message);

	}

	/**
	 * Добавить количество к типу упаковки
	 *
	 * @param PackageType $type
	 * @param int $quantity
	 *
	 * @return $this
	 */
	public function setQuantity(PackageType $type, int $quantity): PackageCollection
	{
		$this->quantities[$type->value] = $quantity;
		return $this;
	}

	/**
	 * Добавить плательщика по упаковке
	 *
	 * @param PackageType $type
	 * @param PayerType $payer
	 *
	 * @return $this
	 */
	public function setPayer(PackageType $type, PayerType $payer): PackageCollection
	{
		$this->payers[$type->value] = $payer;
		return $this;
	}

	/**
	 * Получить плательщика по упаковки
	 *
	 * @return array
	 */
	public function getPayers(): array
	{
		return $this->payers;
	}


}
