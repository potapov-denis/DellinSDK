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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests;

use DateTime;
use DateTimeImmutable;
use Yooogi\DellinSDK\Collections\StatusesCollection;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Enum\OrderBy;
use function func_get_args;

final class OrdersLogRequest implements Arrayable
{
	use DataAware, Login;

	/** @var array|null $docIds */
	private ?array $docIds = null;
	/** @var string|null $orderNumber */
	private ?string $orderNumber = null;

	/** @var string|null $barcode */
	private ?string $barcode = null;
	/** @var DateTimeImmutable|null $orderDate */
	private ?DateTimeImmutable $orderDate = null;
	/** @var DateTimeImmutable|null $dateStart */
	private ?DateTimeImmutable $dateStart = null;
	/** @var DateTimeImmutable|null $dateEnd */
	private ?DateTimeImmutable $dateEnd = null;
	/** @var DateTimeImmutable|null $lastUpdate */
	private ?DateTimeImmutable $lastUpdate = null;


	/** @var StatusesCollection|null $states */
	private ?StatusesCollection $states = null;

	/** @var int|null $page */
	private int $page = 1;

	/** @var OrderBy $orderBy */
	private OrderBy $orderBy = OrderBy::ORDERED_AT;

	/** @var bool $orderDatesAdditional */
	private bool $orderDatesAdditional = false;

	public function __construct()
	{


	}

	public static function create()
	{
		return new self(...func_get_args());
	}

	/**
	 * @return array|null
	 */
	public function getDocIds(): ?array
	{
		return $this->docIds;
	}

	/**
	 * @param array $docIds
	 */
	public function setDocIds(array $docIds): OrdersLogRequest
	{
		$this->docIds = $docIds;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getOrderNumber(): ?string
	{
		return $this->orderNumber;
	}

	/**
	 * @param string|null $orderNumber
	 */
	public function setOrderNumber(?string $orderNumber): OrdersLogRequest
	{
		$this->orderNumber = $orderNumber;
		return $this;
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getOrderDate(): ?DateTimeImmutable
	{
		return $this->orderDate;
	}

	/**
	 * @param string|null $orderDate
	 */
	public function setOrderDate(?string $orderDate): OrdersLogRequest
	{
		$this->orderDate = $orderDate;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getBarcode(): ?string
	{
		return $this->barcode;
	}

	/**
	 * @param string|null $barcode
	 */
	public function setBarcode(?string $barcode): OrdersLogRequest
	{
		$this->barcode = $barcode;
		return $this;
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getDateStart(): ?DateTimeImmutable
	{
		return $this->dateStart;
	}

	/**
	 * @param DateTime|null $dateStart
	 */
	public function setDateStart(?DateTimeImmutable $dateStart): OrdersLogRequest
	{
		$this->dateStart = $dateStart;
		return $this;
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getDateEnd(): ?DateTimeImmutable
	{
		return $this->dateEnd;
	}

	/**
	 * @param DateTime|null $dateEnd
	 *
	 * @return OrdersLogRequest
	 */
	public function setDateEnd(?DateTime $dateEnd): OrdersLogRequest
	{
		$this->dateEnd = $dateEnd;
		return $this;
	}

	/**
	 * @return StatusesCollection|null
	 */
	public function getStates(): ?array
	{
		return $this->states;
	}

	/**
	 * @param StatusesCollection $states
	 *
	 * @return OrdersLogRequest
	 */
	public function setStates(StatusesCollection $states): OrdersLogRequest
	{
		$this->states = $states;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getPage(): ?int
	{
		return $this->page;
	}

	/**
	 * @param int|null $page
	 *
	 * @return OrdersLogRequest
	 */
	public function setPage(?int $page): OrdersLogRequest
	{
		$this->page = $page;
		return $this;
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getLastUpdate(): ?DateTime
	{
		return $this->lastUpdate;
	}

	/**
	 * @param DateTimeImmutable|null $lastUpdate
	 */
	public function setLastUpdate(?DateTimeImmutable $lastUpdate): OrdersLogRequest
	{
		$this->lastUpdate = $lastUpdate;
		return $this;
	}

	/**
	 * @return OrderBy|null
	 */
	public function getOrderBy(): ?OrderBy
	{
		return $this->orderBy;
	}

	/**
	 * @param OrderBy $orderBy
	 */
	public function setOrderBy(OrderBy $orderBy): OrdersLogRequest
	{
		$this->orderBy = $orderBy;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isOrderDatesAdditional(): bool
	{
		return $this->orderDatesAdditional;
	}

	/**
	 * @param bool $orderDatesAdditional
	 */
	public function setOrderDatesAdditional(bool $orderDatesAdditional): OrdersLogRequest
	{
		$this->orderDatesAdditional = $orderDatesAdditional;
		return $this;
	}


	public function toArray(): array
	{
		if ($this->docIds) $this->data['docIds'] = $this->docIds;
		if ($this->orderNumber) $this->data['orderNumber'] = $this->orderNumber;
		if ($this->barcode) $this->data['barcode'] = $this->barcode;
		$this->data['page'] = $this->page;
		$this->data['orderBy'] = $this->orderBy->value;

		if ($this->orderDate) $this->data['orderDate'] = $this->orderDate->format('Y-m-d');
		if ($this->dateStart) $this->data['dateStart'] = $this->dateStart->format('Y-m-d H:i:s');
		if ($this->dateEnd) $this->data['dateEnd'] = $this->dateEnd->format('Y-m-d H:i:s');
		if ($this->lastUpdate) $this->data['lastUpdate'] = $this->lastUpdate->format('Y-m-d H:i:s');
		if ($this->states) {
			$this->data['states'] = [];
			foreach ($this->states as $state) {
				$this->data['states'][] = $state->value;
			}
		}
		if ($this->orderDatesAdditional) $this->data['orderDatesAdditional'] = $this->orderDatesAdditional;

		return $this->data;
	}

}
