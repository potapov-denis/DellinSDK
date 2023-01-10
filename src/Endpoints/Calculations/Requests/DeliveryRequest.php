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

namespace Yooogi\DellinSDK\Endpoints\Calculations\Requests;

use DateTimeImmutable;
use Yooogi\DellinSDK\Collections\RequirementsCollection;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Entities\Handling;
use Yooogi\DellinSDK\Enum\HandlingType;


/**
 * Запрос расчета доставки до адреса
 *
 * @see https://dev.dellin.ru/api/calculation/delivery/
 */
final class DeliveryRequest implements Arrayable
{
	use DataAware, Login;

	private string $arrivalPoint;
	private string $docSQLUid;
	private DateTimeImmutable $calculateDate;
	private ?DateTimeImmutable $startArrivalPeriodVisit = null;
	private ?DateTimeImmutable $endArrivalPeriodVisit = null;
	private ?RequirementsCollection $arrivalServices = null;
	private bool $arrivalFixedTimeVisit = false;
	private ?Handling $handling = null;

	/**
	 * Запрос расчета доставки до адреса
	 *
	 * @param string $arrivalPoint
	 * @param string $docSQLUid
	 * @param DateTimeImmutable $calculateDate
	 */
	public function __construct(string $arrivalPoint, string $docSQLUid, DateTimeImmutable $calculateDate)
	{
		$this->setArrivalPoint($arrivalPoint);
		$this->setDocSQLUid($docSQLUid);
		$this->setCalculateDate($calculateDate);
	}

	/**
	 * Запрос расчета доставки до адреса
	 *
	 * @param string $arrivalPoint
	 * @param string $docSQLUid
	 * @param DateTimeImmutable $calculateDate
	 *
	 * @return DeliveryRequest;
	 */

	public static function create(string $arrivalPoint, string $docSQLUid, DateTimeImmutable $calculateDate): self
	{
		return new self(...func_get_args());
	}

	/**
	 * @return string
	 */
	public function getArrivalPoint(): string
	{
		return $this->arrivalPoint;
	}

	/**
	 * @param string $arrivalPoint
	 *
	 * @return DeliveryRequest
	 */
	public function setArrivalPoint(string $arrivalPoint): DeliveryRequest
	{
		$this->arrivalPoint = $arrivalPoint;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDocSQLUid(): string
	{
		return $this->docSQLUid;
	}

	/**
	 * @param string $docSQLUid
	 *
	 * @return DeliveryRequest
	 */
	public function setDocSQLUid(string $docSQLUid): DeliveryRequest
	{
		$this->docSQLUid = $docSQLUid;
		return $this;
	}

	/**
	 * @return DateTimeImmutable
	 */
	public function getCalculateDate(): DateTimeImmutable
	{
		return $this->calculateDate;
	}

	/**
	 * @param DateTimeImmutable $calculateDate
	 *
	 * @return DeliveryRequest
	 */
	public function setCalculateDate(DateTimeImmutable $calculateDate): DeliveryRequest
	{
		$this->calculateDate = $calculateDate;
		return $this;
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getStartArrivalPeriodVisit(): ?DateTimeImmutable
	{
		return $this->startArrivalPeriodVisit;
	}

	/**
	 * @param DateTimeImmutable|null $startArrivalPeriodVisit
	 *
	 * @return DeliveryRequest
	 */
	public function setStartArrivalPeriodVisit(?DateTimeImmutable $startArrivalPeriodVisit): DeliveryRequest
	{
		$this->startArrivalPeriodVisit = $startArrivalPeriodVisit;
		return $this;
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getEndArrivalPeriodVisit(): ?DateTimeImmutable
	{
		return $this->endArrivalPeriodVisit;
	}

	/**
	 * @param DateTimeImmutable|null $endArrivalPeriodVisit
	 *
	 * @return DeliveryRequest
	 */
	public function setEndArrivalPeriodVisit(?DateTimeImmutable $endArrivalPeriodVisit): DeliveryRequest
	{
		$this->endArrivalPeriodVisit = $endArrivalPeriodVisit;
		return $this;
	}

	/**
	 * @return RequirementsCollection|null
	 */
	public function getArrivalServices(): ?RequirementsCollection
	{
		return $this->arrivalServices;
	}

	/**
	 * @param RequirementsCollection|null $arrivalServices
	 *
	 * @return DeliveryRequest
	 */
	public function setArrivalServices(?RequirementsCollection $arrivalServices): DeliveryRequest
	{
		$this->arrivalServices = $arrivalServices;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isArrivalFixedTimeVisit(): bool
	{
		return $this->arrivalFixedTimeVisit;
	}

	/**
	 * @param bool $arrivalFixedTimeVisit
	 *
	 * @return DeliveryRequest
	 */
	public function setArrivalFixedTimeVisit(bool $arrivalFixedTimeVisit): DeliveryRequest
	{
		$this->arrivalFixedTimeVisit = $arrivalFixedTimeVisit;
		return $this;
	}

	/**
	 * @return Handling|null
	 */
	public function getHandling(): ?Handling
	{
		return $this->handling;
	}

	/**
	 * @param Handling|null $handling
	 *
	 * @return DeliveryRequest
	 */
	public function setHandling(?Handling $handling): DeliveryRequest
	{
		$this->handling = $handling;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['arrivalPoint'] = $this->arrivalPoint;
		$this->data['docSQLUid'] = $this->docSQLUid;
		$this->data['calculateDate'] = $this->calculateDate->format('Y-m-d');

		if ($this->handling) {
			foreach ($this->handling->toArray() as $handlingType => $handlingValue) {
				if ($handlingValue !== false) {
					$this->data['arrivalUnLoading'][] = ['uid' => HandlingType::tryFromKey($handlingType),
						'value' => is_bool($handlingValue) ? true : (string)$handlingValue];
				}
			}
		}

		if ($this->arrivalServices) {
			foreach ($this->arrivalServices as $arrivalService) {
				$this->data['arrivalServices'][] = $arrivalService->value;
			}
		}

		if ($this->arrivalFixedTimeVisit) {
			$this->data['arrivalFixedTimeVisit'] = $this->arrivalFixedTimeVisit;
		}

		if ($this->startArrivalPeriodVisit) {
			$this->data['ArrivalPeriodVisit']['start'] = $this->startArrivalPeriodVisit->format('H:i');
		}
		if ($this->endArrivalPeriodVisit) {
			$this->data['ArrivalPeriodVisit']['end'] = $this->endArrivalPeriodVisit->format('H:i');
		}
		return $this->data;
	}
}
