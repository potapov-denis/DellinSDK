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

namespace Yooogi\DellinSDK\Endpoints\Services\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Enum\BlockType;
use Yooogi\DellinSDK\Enum\DeliveryType;
use function func_get_args;


final class ConditionsRequest implements Arrayable
{
	use DataAware, Login, MetaData;

	private array $blocks = [];
	private string $derivalPoint;
	private string $arrivalPoint;
	private ?float $volume = null;
	private ?float $weight = null;
	private ?float $length = null;
	private ?float $height = null;
	private ?float $width = null;
	private ?int $derivalTerminalID = null;
	private ?int $arrivalTerminalID = null;
	private DeliveryType $deliveryType;
	private bool $derivalDoor = false;
	private bool $arrivalDoor = false;

	/**
	 * Запрос информации об ограничениях и возможных значениях параметров в зависимости от условий заказа
	 *
	 * @param DeliveryType $deliveryType Вид доставки
	 * @param string $derivalPoint Код КЛАДР пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 * @param string $arrivalPoint Код КЛАДР пункта прибытия груза. Может быть указан код КЛАДР города или улицы.
	 * @param float $weight Вес, кг
	 * @param float $length Длина, м
	 * @param float $width Ширина, м
	 * @param float $height Высота, м
	 * @param BlockType[]|null $blocks Список дополнительных услуг (предоставление которых может быть ограничено из-за условий заказа) по которым необходима информация.
	 *
	 */
	public function __construct(DeliveryType $deliveryType, string $derivalPoint, string $arrivalPoint, float $weight, float $length, float $width, float $height,
	                            ?array       $blocks = [])
	{
		$this->setDeliveryType($deliveryType);
		$this->setDerivalPoint($derivalPoint);
		$this->setArrivalPoint($arrivalPoint);
		$this->setBlocks($blocks);
		$this->setWeight($weight);
		$this->setHeight($height);
		$this->setLength($length);
		$this->setWidth($width);

	}

	/**
	 * Запрос информации об ограничениях и возможных значениях параметров в зависимости от условий заказа
	 *
	 * @param DeliveryType $deliveryType Вид доставки
	 * @param string $derivalPoint Код КЛАДР пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 * @param string $arrivalPoint Код КЛАДР пункта прибытия груза. Может быть указан код КЛАДР города или улицы.
	 * @param float $weight Вес, кг
	 * @param float $length Длина, м
	 * @param float $width Ширина, м
	 * @param float $height Высота, м
	 * @param BlockType[]|null $blocks Список дополнительных услуг (предоставление которых может быть ограничено из-за условий заказа) по которым необходима информация.
	 *
	 */
	public static function create(DeliveryType $deliveryType, string $derivalPoint, string $arrivalPoint, float $weight, float $length, float $width, float $height,
	                              ?array       $blocks = []): self
	{
		return new self(...func_get_args());
	}

	/**
	 * Список дополнительных услуг (предоставление которых может быть ограничено из-за условий заказа) по которым необходима информация.
	 *
	 * @return BlockType[]
	 */
	public function getBlocks(): array
	{
		return $this->blocks;
	}

	/**
	 * Список дополнительных услуг (предоставление которых может быть ограничено из-за условий заказа) по которым необходима информация.
	 *
	 * @param BlockType[] $blocks
	 */
	public function setBlocks(array $blocks): ConditionsRequest
	{
		$this->blocks = $blocks;
		return $this;
	}

	/**
	 * Код КЛАДР пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 *
	 * @return string
	 */
	public function getDerivalPoint(): string
	{
		return $this->derivalPoint;
	}

	/**
	 * Код КЛАДР пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 *
	 * @param string $derivalPoint
	 *
	 * @return ConditionsRequest
	 */
	public function setDerivalPoint(string $derivalPoint): ConditionsRequest
	{
		$this->derivalPoint = $derivalPoint;
		return $this;
	}

	/**
	 * Код КЛАДР пункта прибытия груза. Может быть указан код КЛАДР города или улицы.
	 *
	 * @return string
	 */
	public function getArrivalPoint(): string
	{
		return $this->arrivalPoint;
	}

	/**
	 * Код КЛАДР пункта прибытия груза. Может быть указан код КЛАДР города или улицы.
	 *
	 * @param string $arrivalPoint
	 *
	 * @return ConditionsRequest
	 */
	public function setArrivalPoint(string $arrivalPoint): ConditionsRequest
	{
		$this->arrivalPoint = $arrivalPoint;
		return $this;
	}

	/**
	 * Объем груза, куб. м.
	 *
	 * @return float
	 */
	public function getVolume(): float
	{
		return (float)$this->volume;
	}

	/**
	 * Объем груза, куб. м.
	 *
	 * @param float $volume
	 *
	 * @return ConditionsRequest
	 */
	public function setVolume(float $volume): ConditionsRequest
	{
		$this->volume = $volume;
		return $this;
	}

	/**
	 * Вес груза, кг
	 *
	 * @return float
	 */
	public function getWeight(): float
	{
		return (float)$this->weight;
	}

	/**
	 * Вес груза, кг
	 *
	 * @param float $weight
	 *
	 * @return ConditionsRequest
	 */
	public function setWeight(float $weight): ConditionsRequest
	{
		$this->weight = $weight;
		return $this;
	}

	/**
	 * ID терминала отправки груза
	 *
	 * @return int|null
	 */
	public function getDerivalTerminalID(): ?int
	{
		return $this->derivalTerminalID;
	}

	/**
	 * ID терминала отправки груза
	 *
	 * @param int|null $derivalTerminalID
	 *
	 * @return ConditionsRequest
	 */
	public function setDerivalTerminalID(?int $derivalTerminalID): ConditionsRequest
	{
		$this->derivalTerminalID = $derivalTerminalID;
		return $this;
	}

	/**
	 * ID терминала выдачи груза
	 *
	 * @return int|null
	 */
	public function getArrivalTerminalID(): ?int
	{
		return $this->arrivalTerminalID;
	}

	/**
	 * ID терминала выдачи груза
	 *
	 * @param int|null $arrivalTerminalID
	 *
	 * @return ConditionsRequest
	 */
	public function setArrivalTerminalID(?int $arrivalTerminalID): ConditionsRequest
	{
		$this->arrivalTerminalID = $arrivalTerminalID;
		return $this;
	}

	/**
	 * Вид доставки
	 *
	 * @return DeliveryType
	 * @see DeliveryType
	 */
	public function getDeliveryType(): DeliveryType
	{
		return $this->deliveryType;
	}

	/**
	 * Вид доставки
	 *
	 * @param DeliveryType $deliveryType
	 *
	 * @return ConditionsRequest
	 * @see DeliveryType
	 */
	public function setDeliveryType(DeliveryType $deliveryType): ConditionsRequest
	{
		$this->deliveryType = $deliveryType;
		return $this;
	}

	/**
	 * Признак заказа доставки от адреса.
	 *
	 * @return bool
	 */
	public function isDerivalDoor(): bool
	{
		return (bool)$this->derivalDoor;
	}

	/**
	 * Признак заказа доставки от адреса.
	 *
	 * @param bool $derivalDoor
	 *
	 * @return ConditionsRequest
	 */
	public function setDerivalDoor(bool $derivalDoor): ConditionsRequest
	{
		$this->derivalDoor = $derivalDoor;
		return $this;
	}

	/**
	 * Признак заказа доставки до адреса.
	 *
	 * @return bool
	 */
	public function isArrivalDoor(): bool
	{
		return (bool)$this->arrivalDoor;
	}

	/**
	 * Признак заказа доставки до адреса.
	 *
	 * @param bool $arrivalDoor
	 *
	 * @return ConditionsRequest
	 */
	public function setArrivalDoor(bool $arrivalDoor): ConditionsRequest
	{
		$this->arrivalDoor = $arrivalDoor;
		return $this;
	}

	/**
	 * Получить длину груза, метры
	 *
	 * @return float|null
	 */
	public function getLength(): ?float
	{
		return $this->length;
	}

	/**
	 * Установить длину груза, метры
	 *
	 * @param float|null $length
	 *
	 * @return ConditionsRequest
	 */
	public function setLength(?float $length): ConditionsRequest
	{
		$this->length = $length;
		return $this;
	}

	/**
	 * Получить высоту груза, метры
	 *
	 * @return float|null
	 */
	public function getHeight(): ?float
	{
		return $this->height;
	}

	/**
	 * Установить высоту груза, метры
	 *
	 * @param float|null $height
	 *
	 * @return ConditionsRequest
	 */
	public function setHeight(?float $height): ConditionsRequest
	{
		$this->height = $height;
		return $this;
	}

	/**
	 * Получить ширину груза, метры
	 *
	 * @return float|null
	 */
	public function getWidth(): ?float
	{
		return $this->width;
	}

	/**
	 * Установить ширину груза, метры
	 *
	 * @param float|null $width
	 *
	 * @return ConditionsRequest
	 */
	public function setWidth(?float $width): ConditionsRequest
	{
		$this->width = $width;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['blocks'] = array_map(static function ($block) {
			return $block->value;
		}, $this->blocks);
		$this->data['derivalPoint'] = $this->derivalPoint;
		$this->data['arrivalPoint'] = $this->arrivalPoint;

		if ($this->volume) {
			$this->data['volume'] = (round($this->volume, 3) > 0.001) ? round($this->volume, 3) : 0.001;
		} else {
			$this->data['volume'] = (round($this->length * $this->width * $this->height, 3) > 0.001)
				? round($this->length * $this->width * $this->height, 3)
				: 0.001;
		}
		if ($this->weight) $this->data['weight'] = ($this->weight > 0.001) ? $this->weight : 0.001;
		if ($this->length) $this->data['length'] = ($this->length > 0.01) ? $this->length : 0.01;
		if ($this->width) $this->data['width'] = ($this->width > 0.01) ? $this->width : 0.01;
		if ($this->height) $this->data['height'] = ($this->height > 0.01) ? $this->height : 0.01;

		$this->data['derivalTerminalID'] = ($this->derivalTerminalID) ?: null;
		$this->data['arrivalTerminalID'] = ($this->arrivalTerminalID) ?: null;
		$this->data['deliveryType'] = $this->deliveryType->getId();
		$this->data['derivalDoor'] = $this->derivalDoor;
		$this->data['arrivalDoor'] = $this->arrivalDoor;


		return $this->data;
	}
}
