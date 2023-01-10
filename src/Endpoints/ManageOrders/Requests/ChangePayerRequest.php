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

declare (strict_types=1);


namespace Yooogi\DellinSDK\Endpoints\ManageOrders\Requests;

use Yooogi\DellinSDK\Entities\Counteragent;
use Yooogi\DellinSDK\Entities\Member;
use Yooogi\DellinSDK\Entities\OrderId;

/**
 * Запрос сервиса изменения плательщика
 */
final class ChangePayerRequest extends OrderId
{
	private ?string $docUID = null;
	private ?string $counteragentUID = null;
	private ?Counteragent $third = null;
	private ?Member $member = null;

	/**
	 * Запрос сервиса изменения плательщика
	 *
	 * @param string $orderID Номер заказа, по которому необходимо изменить плательщика
	 * @param string|null $docUID UID накладной. UID накладной можно уточнить при помощи метода 'Журнал заказов'.
	 * @param string|null $counteragentUID UID контрагента
	 * @param Counteragent|null $third Данные контрагента-третьего лица в виде набора параметров
	 * @param Member|null $member Данные нового плательщика
	 *
	 * @see https://dev.dellin.ru/api/order/change-payer/
	 */
	public function __construct(string $orderID, ?string $docUID = null, ?string $counteragentUID = null, ?Counteragent $third = null, ?Member $member = null)
	{
		parent::__construct($orderID);
		$this->setDocUID($docUID);
		$this->setCounteragentUID($counteragentUID);
		$this->setThird($third);
		$this->setMember($member);
	}

	/**
	 * Запрос сервиса изменения плательщика
	 *
	 * @param string $orderID Номер заказа, по которому необходимо изменить плательщика
	 * @param string|null $docUID UID накладной. UID накладной можно уточнить при помощи метода 'Журнал заказов'.
	 * @param string|null $counteragentUID UID контрагента
	 * @param Counteragent|null $third Данные контрагента-третьего лица в виде набора параметров
	 * @param Member|null $member Данные нового плательщика
	 *
	 * @return ChangePayerRequest
	 *
	 * @see https://dev.dellin.ru/api/order/change-payer/
	 */
	public static function create(string $orderID, ?string $docUID = null, ?string $counteragentUID = null, ?Counteragent $third = null, ?Member $member = null): ChangePayerRequest
	{
		return new ChangePayerRequest(...\func_get_args());
	}

	/**
	 * UID накладной. UID накладной можно уточнить при помощи метода 'Журнал заказов'.
	 *
	 * @return string|null
	 */
	public function getDocUID(): ?string
	{
		return $this->docUID;
	}

	/**
	 * UID накладной. UID накладной можно уточнить при помощи метода 'Журнал заказов'.
	 *
	 * @param string|null $docUID
	 */
	public function setDocUID(?string $docUID): ChangePayerRequest
	{
		$this->docUID = $docUID;
		return $this;
	}

	/**
	 * UID контрагента
	 *
	 * @return string|null
	 */
	public function getCounteragentUID(): ?string
	{
		return $this->counteragentUID;
	}

	/**
	 * @param string|null $counteragentUID
	 */
	public function setCounteragentUID(?string $counteragentUID): ChangePayerRequest
	{
		$this->counteragentUID = $counteragentUID;
		return $this;
	}

	/**
	 * Данные контрагента-третьего лица в виде набора параметров
	 *
	 * @return Counteragent|null
	 */
	public function getThird(): ?Counteragent
	{
		return $this->third;
	}

	/**
	 * Данные контрагента-третьего лица в виде набора параметров
	 *
	 * @param Counteragent|null $third
	 */
	public function setThird(?Counteragent $third): ChangePayerRequest
	{
		$this->third = $third;
		return $this;
	}

	/**
	 * Данные плательщика
	 *
	 * @return Member|null
	 */
	public function getMember(): ?Member
	{
		return $this->member;
	}

	/**
	 * Данные плательщика
	 *
	 * @param Member|null $member
	 */
	public function setMember(?Member $member): ChangePayerRequest
	{
		$this->member = $member;
		return $this;
	}


	public function toArray(): array
	{

		if ($this->member) {

			$this->member->setAuth($this->getAuth());
			$this->data = array_merge($this->member->toArray(), $this->data);

			/*unset ($this->data['phoneNumbers'], $this->data['contactPersons']);
			if ($this->member->getCounteragentID()) $this->data['counteragentID'] = $this->member->getCounteragentID();
			if ($this->member->getCounteragent()) $this->data['counteragent'] = $this->member->getCounteragent()->toArray();
			if ($this->member->getContactIDs()) $this->data['contactIDs'] = $this->member->slice($this->member->getContactIDs());
			if ($this->member->getPhoneIDs()) $this->data['phoneIds'] = $this->member->slice($this->member->getPhoneIDs());


			if ($this->member->getContactPersons()) {
				$contactPersons = $this->member->getContactPersons();
				array_walk($contactPersons, function ($value) {
					$this->member->data['contactPersons'][] = $value->toArray();

				});
				$this->member->slice($this->data['contactPersons']);
			}

			if ($this->member->getPhoneNumbers()) {
				$phoneNumbers = $this->member->getPhoneNumbers();
				array_walk($phoneNumbers, function ($value) {
					$this->data['phoneNumbers'][] = $value->toArray();
				});
				$this->member->slice($this->data['phoneNumbers']);
			}


			$this->data['contactIDs'] = $this->member->getContactIDs();
			$this->data['contactPersons'] = $this->member->getContactPersons();*/
		}
		$this->data['orderID'] = $this->orderID;
		if ($this->docUID) $this->data['docUID'] = $this->docUID;
		if ($this->third) $this->data['third'] = $this->third->toArray();
		$this->data['third']['phoneIds'] = [123131323123];
		$this->data['third']['contactIDs'] = [123131323123];

		print_r($this->data);
		return $this->data;
	}
}