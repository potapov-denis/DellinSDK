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
use Yooogi\DellinSDK\Enum\AcDoc;
use Yooogi\DellinSDK\Enum\PayerType;


class AccompanyingDocumentsCollection extends Collection
{

	public array $payers;

	/**
	 * Коллекция сопроводительных документов
	 *
	 * @param AcDoc|AcDoc[] $accompanyingDocuments
	 * @param int $flags
	 * @param string $iteratorClass
	 */

	public function __construct(object|array $accompanyingDocuments = [], int $flags = 0, string $iteratorClass = "ArrayIterator")
	{
		if ($this->validate($accompanyingDocuments)) {
			parent::__construct($accompanyingDocuments, $flags, $iteratorClass);
		} else {

			$message = $this->getExceptionMessage();
			throw new CompatibleException('Несовместимые типы сопроводительных документов. ' . $message);

		}

	}

	/**
	 * Коллекция сопроводительных документов
	 *
	 * @param AcDoc|AcDoc[] $accompanyingDocuments
	 * @param int $flags
	 * @param string $iteratorClass
	 *
	 * @return AccompanyingDocumentsCollection
	 */


	public static function create(object|array $accompanyingDocuments = [], int $flags = 0, string $iteratorClass = 'ArrayIterator'): self
	{
		return new self(...func_get_args());

	}

	public static function renderAccompanyingDocuments(AccompanyingDocumentsCollection $accompanyingDocumentsCollection): array
	{
		$accompanyingDocuments = [];
		foreach ($accompanyingDocumentsCollection as $accompanyingDocument) {
			if ($accompanyingDocument instanceof AcDoc) {
				$acdoc['action'] = $accompanyingDocument->value;
				if ($accompanyingDocumentsCollection->getPayer($accompanyingDocument)?->value) {
					$acdoc['payer'] = $accompanyingDocumentsCollection->getPayer($accompanyingDocument)->value;
				}
				$accompanyingDocuments[] = $acdoc;
			}
		}
		return $accompanyingDocuments;
	}

	/**
	 * Получить плательщика по доставке документов
	 *
	 * @param AcDoc $acdoc
	 *
	 * @return PayerType|null
	 */
	public function getPayer(AcDoc $acdoc): ?PayerType
	{
		return ($this->payers[$acdoc->value]) ?? null;
	}

	/**
	 * Добавить плательщика по доставке документов
	 *
	 * @param Acdoc $acdoc
	 * @param PayerType $payer
	 *
	 * @return AccompanyingDocumentsCollection
	 */
	public function setPayer(AcDoc $acdoc, PayerType $payer): AccompanyingDocumentsCollection
	{
		$this->payers[$acdoc->value] = $payer;
		return $this;
	}

	/**
	 * Получить плательщика по доставке документов
	 *
	 * @return array
	 */
	public function getPayers(): array
	{
		return $this->payers;
	}


}
