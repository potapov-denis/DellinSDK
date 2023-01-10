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

namespace Yooogi\DellinSDK\Entities;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\DocumentType;

final class Member implements Arrayable
{
	use DataAware;

	/** @var int */
	private ?int $counteragentID = null;
	private ?Counteragent $counteragent = null;
	private ?array $contactIDs = null;
	private ?array $phoneIDs = null;
	/** @var ContactPerson[]|null */
	private ?array $contactPersons = null;
	/** @var PhoneNumber[]|null */
	private ?array $phoneNumbers = null;
	private ?string $email = null;
	private ?DataForReceipt $dataForReceipt = null;
	private bool $auth = false;

	private ?string $inn = null;
	private ?DocumentType $docType = null;
	private ?string $docSeries = null;
	private ?string $docNumber = null;
	private ?string $terminal = null;

	/**
	 * Участник перевозки
	 *
	 * @param ?Counteragent $counteragent Контрагент в форме набора параметров.
	 * Если пользователь не авторизован, то параметр является обязательным. Если пользователь авторизован, то обязательной является передача одного из взаимоисключающих
	 * параметров 'counteragentID' или 'counteragent'
	 *
	 * @param ?int $counteragentID
	 * ID контрагента из 'Адресной книги'.
	 * Если пользователь не авторизован, то параметр игнорируется. Если пользователь авторизован, то передача одного из взаимоисключающих параметров 'counteragentID' или
	 * 'counteragent' является обязательной
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header14
	 */
	public function __construct(?Counteragent $counteragent = null, ?int $counteragentID = null)
	{
		$this->setCounteragentID($counteragentID);
		$this->setCounteragent($counteragent);
	}

	/**
	 * Участник перевозки
	 *
	 * @param ?Counteragent $counteragent Контрагент в форме набора параметров.
	 * Если пользователь не авторизован, то параметр является обязательным. Если пользователь авторизован, то обязательной является передача одного из взаимоисключающих
	 * параметров 'counteragentID' или 'counteragent'
	 *
	 * @param ?int $counteragentID
	 * ID контрагента из 'Адресной книги'.
	 * Если пользователь не авторизован, то параметр игнорируется. Если пользователь авторизован, то передача одного из взаимоисключающих параметров 'counteragentID' или
	 * 'counteragent' является обязательной
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header14
	 */
	public static function create(?Counteragent $counteragent = null, ?int $counteragentID = null): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return ?int
	 * ID контрагента из 'Адресной книги'.
	 * Если пользователь не авторизован, то параметр игнорируется. Если пользователь авторизован, то передача одного из взаимоисключающих параметров 'counteragentID' или
	 * 'counteragent' является обязательной
	 */
	public function getCounteragentID(): ?int
	{
		return $this->counteragentID;
	}

	/**
	 *  ID контрагента из 'Адресной книги'.
	 * Если пользователь не авторизован, то параметр игнорируется. Если пользователь авторизован, то передача одного из взаимоисключающих параметров 'counteragentID' или
	 * 'counteragent' является обязательной
	 *
	 * @param int $counteragentID
	 */
	public function setCounteragentID(?int $counteragentID): Member
	{
		$this->counteragentID = $counteragentID;
		return $this;
	}

	/**
	 * Контрагент в форме набора параметров.
	 * Если пользователь не авторизован, то параметр является обязательным. Если пользователь авторизован, то обязательной является передача одного из взаимоисключающих
	 * параметров 'counteragentID' или 'counteragent'
	 * @return Counteragent|null
	 */
	public function getCounteragent(): ?Counteragent
	{
		return $this->counteragent;
	}

	/**
	 * Контрагент в форме набора параметров.
	 * Если пользователь не авторизован, то параметр является обязательным. Если пользователь авторизован, то обязательной является передача одного из взаимоисключающих
	 * параметров 'counteragentID' или 'counteragent'
	 *
	 *
	 * @param Counteragent|null $counteragent
	 */
	public function setCounteragent(?Counteragent $counteragent): Member
	{
		$this->counteragent = $counteragent;
		return $this;
	}

	/**
	 * Список ID контактных лиц из 'Адресной книги'.
	 *
	 * Максимальное количество элементов в массиве - 3.
	 *
	 * @return array|null
	 */
	public function getContactIDs(): ?array
	{
		return $this->contactIDs;
	}

	/**
	 * Список ID контактных лиц из 'Адресной книги'.
	 *
	 * Максимальное количество элементов в массиве - 3.
	 *
	 * @param array|null $contactIDs
	 */
	public function setContactIDs(?array $contactIDs): Member
	{
		$this->contactIDs = $contactIDs;
		return $this;
	}

	/**
	 *
	 * Список ID телефонных номеров из 'Адресной книги'.
	 *
	 * Максимальное количество элементов в массиве - 3.
	 *
	 * @return array|null
	 */
	public function getPhoneIDs(): ?array
	{
		return $this->phoneIDs;
	}

	/**
	 *
	 * Список ID телефонных номеров из 'Адресной книги'.
	 *
	 * Максимальное количество элементов в массиве - 3.
	 *
	 * @param array|null $phoneIDs
	 */
	public function setPhoneIDs(?array $phoneIDs): Member
	{
		$this->phoneIDs = $phoneIDs;
		return $this;
	}

	/**
	 * Список контактных лиц.
	 * Для авторизованных пользователей максимальное количество элементов в массиве - 3, для неавторизванных - 1.
	 *
	 * @return ContactPerson[]|null
	 */
	public function getContactPersons(): ?array
	{
		return $this->contactPersons;
	}

	/**
	 * Список контактных лиц.
	 *
	 * Для авторизованных пользователей максимальное количество элементов в массиве - 3, для неавторизванных - 1.
	 *
	 * @param ContactPerson[]|null $contactPersons
	 */
	public function setContactPersons(?array $contactPersons): Member
	{
		$this->contactPersons = $contactPersons;
		return $this;
	}

	/**
	 * Список телефонных номеров.
	 *
	 * Для авторизованных пользователей максимальное количество элементов в массиве - 3, для неавторизванных - 1.
	 *
	 * @return PhoneNumber[]|null
	 */
	public function getPhoneNumbers(): ?array
	{
		return $this->phoneNumbers;
	}

	/**
	 * Список телефонных номеров.
	 *
	 * Для авторизованных пользователей максимальное количество элементов в массиве - 3, для неавторизванных - 1.
	 *
	 * @param PhoneNumber[]|null $phoneNumbers
	 */
	public function setPhoneNumbers(?array $phoneNumbers): Member
	{
		$this->phoneNumbers = $phoneNumbers;
		return $this;
	}

	/**
	 * Email для отправки уведомлений участнику перевозки
	 * @return string|null
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * Email для отправки уведомлений участнику перевозки
	 *
	 * @param string|null $email
	 */
	public function setEmail(?string $email): Member
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * Согласие на получение электронного чека об оплате. Доступные значения:
	 *
	 * 'true' - пользователь ввел 'phone' и/или 'email' для отправки чека;
	 * 'false' - пользователь отказался предоставлять контактные данные для отправки чека
	 *
	 * @return DataForReceipt|null
	 */
	public function getDataForReceipt(): ?DataForReceipt
	{
		return $this->dataForReceipt;
	}

	/**
	 * Согласие на получение электронного чека об оплате. Доступные значения:
	 *
	 * 'true' - пользователь ввел 'phone' и/или 'email' для отправки чека;
	 * 'false' - пользователь отказался предоставлять контактные данные для отправки чека
	 *
	 *
	 * @param DataForReceipt|null $dataForReceipt
	 */
	public function setDataForReceipt(?DataForReceipt $dataForReceipt): Member
	{
		$this->dataForReceipt = $dataForReceipt;
		return $this;
	}

	/**
	 * ИНН (для юридических лиц).
	 * Максимальная допустимая длина поля зависит от страны и организационно-правовой формы контрагента
	 *
	 * @return string
	 */
	public function getInn(): string
	{
		return $this->inn;
	}

	/**
	 * ИНН (для юридических лиц).
	 * Максимальная допустимая длина поля зависит от страны и организационно-правовой формы контрагента
	 *
	 * @param string $inn
	 */
	public function setInn(string $inn): Member
	{
		$this->inn = $inn;
		return $this;
	}

	/**
	 * Тип документа (для физических лиц)
	 *
	 * Доступные варианты:
	 *
	 * 'passport' - паспорт;
	 * 'foreignPassport' - заграничный паспорт (для некоторых стран данное значение недоступно);
	 * 'drivingLicence' - водительское удостоверение
	 *
	 * @return DocumentType
	 */
	public function getDocType(): DocumentType
	{
		return $this->docType;
	}

	/**
	 * Тип документа (для физических лиц)
	 *
	 * Доступные варианты:
	 *
	 * 'passport' - паспорт;
	 * 'foreignPassport' - заграничный паспорт (для некоторых стран данное значение недоступно);
	 * 'drivingLicence' - водительское удостоверение
	 *
	 *
	 * @param DocumentType $docType
	 */
	public function setDocType(DocumentType $docType): Member
	{
		$this->docType = $docType;
		return $this;
	}

	/**
	 * Серия документа (для физических лиц)
	 *
	 * @return string
	 */
	public function getDocSeries(): string
	{
		return $this->docSeries;
	}

	/**
	 * Серия документа (для физических лиц)
	 *
	 * @param string $docSeries
	 */
	public function setDocSeries(string $docSeries): Member
	{
		$this->docSeries = $docSeries;
		return $this;
	}

	/**
	 * Номер документа (для физических лиц). Формат номера зависит от страны
	 *
	 * @return string
	 */
	public function getDocNumber(): string
	{
		return $this->docNumber;
	}

	/**
	 * Номер документа (для физических лиц). Формат номера зависит от страны
	 *
	 * @param string $docNumber
	 */
	public function setDocNumber(string $docNumber): Member
	{
		$this->docNumber = $docNumber;
		return $this;
	}

	/**
	 * Код КЛАДР пункта отправления (для объекта 'request.sender') или доставки (для объекта 'request.receiver') .
	 * Может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 * @return string
	 */
	public function getTerminal(): string
	{
		return $this->terminal;
	}

	/**
	 * Код КЛАДР пункта отправления (для объекта 'request.sender') или доставки (для объекта 'request.receiver') .
	 * Может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 *
	 *
	 * @param string $terminal
	 */
	public function setTerminal(string $terminal): Member
	{
		$this->terminal = $terminal;
		return $this;
	}

	public function toArray(): array
	{
		unset ($this->data['phoneNumbers'], $this->data['contactPersons']);
		if ($this->counteragentID) $this->data['counteragentID'] = $this->counteragentID;
		if ($this->counteragent) $this->data['counteragent'] = $this->counteragent->toArray();
		if ($this->contactIDs) $this->data['contactIDs'] = $this->slice($this->contactIDs);
		if ($this->phoneIDs) $this->data['phoneIds'] = $this->slice($this->phoneIDs);


		if ($this->contactPersons) {
			array_walk($this->contactPersons, function ($value) {
				$this->data['contactPersons'][] = $value->toArray();

			});
			$this->slice($this->data['contactPersons']);
		}

		if ($this->phoneNumbers) {
			array_walk($this->phoneNumbers, function ($value) {
				$this->data['phoneNumbers'][] = $value->toArray();
			});
			$this->slice($this->data['phoneNumbers']);
		}

		if ($this->inn) $this->data['inn'] = $this->inn;
		if ($this->docType) $this->data['docType'] = $this->docType->value;
		if ($this->docSeries) $this->data['docSeries'] = $this->docSeries;
		if ($this->docNumber) $this->data['docNumber'] = $this->docNumber;
		if ($this->terminal) $this->data['terminal'] = $this->terminal;

		if ($this->email) $this->data['email'] = $this->email;
		if ($this->dataForReceipt) $this->data['dataForReceipt'] = $this->dataForReceipt->toArray();
		return $this->data;
	}

	/**
	 * Если пользователь авторизован - допускается 3 элемента массива, если нет - 1.
	 *
	 * @param array $inputArray
	 *
	 * @return array
	 */
	public function slice(array $inputArray): array
	{
		$limit = ($this->isAuth()) ? 2 : 0;
		return array_slice($inputArray, 0, $limit);
	}

	/**
	 * @return bool
	 */
	public function isAuth(): bool
	{
		return $this->auth;
	}

	/**
	 * @param bool $auth
	 */
	public function setAuth(bool $auth): Member
	{
		$this->auth = $auth;
		return $this;
	}
}
