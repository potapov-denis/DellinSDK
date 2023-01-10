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
use function func_get_args;


final class Counteragent implements Arrayable
{
	use DataAware;

	private string $name;
	private ?string $form;
	private ?CustomForm $customForm;
	private ?Document $document;
	private ?string $phone = null;
	private ?string $inn = null;
	private ?Address $juridicalAddress = null;
	private bool $isAnonym = false;
	private bool $save = false;

	/**
	 * Контрагент
	 *
	 * @param string $name Имя контрагента или название юр. лица
	 * @param ?string $form UID организационно-правовой формы (ОПФ). Найти ОПФ можно при помощи метода 'Поиск ОПФ' или же метода 'Поиск контрагентов' (метод доступен
	 * неавторизованным пользователям и позволяет осуществлять поиск по данным ЕГРЮЛ (1) и ЕГРИП (2))
	 * @param ?CustomForm $customForm ОПФ в форме набора параметров.
	 * @param ?Document $document Документ, удостоверяющий личность
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header15
	 */
	public function __construct(string $name, ?string $form = null, ?CustomForm $customForm = null, ?Document $document = null)
	{
		$this->setName($name);
		$this->setForm($form);
		$this->setCustomForm($customForm);
		$this->setDocument($document);

	}

	/**
	 * Контрагент
	 *
	 * @param string $name Имя контрагента или название юр. лица
	 * @param ?string $form UID организационно-правовой формы (ОПФ). Найти ОПФ можно при помощи метода 'Поиск ОПФ' или же метода 'Поиск контрагентов' (метод доступен
	 * неавторизованным пользователям и позволяет осуществлять поиск по данным ЕГРЮЛ (1) и ЕГРИП (2))
	 * @param ?CustomForm $customForm ОПФ в форме набора параметров.
	 * @param ?Document $document Документ, удостоверяющий личность
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header15
	 */
	public static function create(string $name, ?string $form = null, ?CustomForm $customForm = null, ?Document $document = null): self
	{
		return new self(...func_get_args());
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @param string|null $name
	 */
	public function setName(?string $name): Counteragent
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getForm(): ?string
	{
		return $this->form;
	}

	/**
	 * @param string|null $form
	 */
	public function setForm(?string $form): Counteragent
	{
		$this->form = $form;
		return $this;
	}

	/**
	 * @return CustomForm|null
	 */
	public function getCustomForm(): ?CustomForm
	{
		return $this->customForm;
	}

	/**
	 * @param CustomForm|null $customForm
	 */
	public function setCustomForm(?CustomForm $customForm): Counteragent
	{
		$this->customForm = $customForm;
		return $this;
	}

	/**
	 * @return Document|null
	 */
	public function getDocument(): ?Document
	{
		return $this->document;
	}

	/**
	 * @param Document|null $document
	 */
	public function setDocument(?Document $document): Counteragent
	{
		$this->document = $document;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPhone(): ?string
	{
		return $this->phone;
	}

	/**
	 * @param string|null $phone
	 */
	public function setPhone(?string $phone): Counteragent
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getInn(): ?string
	{
		return $this->inn;
	}

	/**
	 * @param string|null $inn
	 */
	public function setInn(?string $inn): Counteragent
	{
		$this->inn = $inn;
		return $this;
	}

	/**
	 * @return Address|null
	 */
	public function getJuridicalAddress(): ?Address
	{
		return $this->juridicalAddress;
	}

	/**
	 * @param Address|null $juridicalAddress
	 */
	public function setJuridicalAddress(?Address $juridicalAddress): Counteragent
	{
		$this->juridicalAddress = $juridicalAddress;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isAnonym(): bool
	{
		return $this->isAnonym;
	}

	/**
	 * @param bool $isAnonym
	 */
	public function setIsAnonym(bool $isAnonym): Counteragent
	{
		$this->isAnonym = $isAnonym;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSave(): bool
	{
		return $this->save;
	}

	/**
	 * @param bool $save
	 */
	public function setSave(bool $save): Counteragent
	{
		$this->save = $save;
		return $this;
	}

	public function toArray(): array
	{
		$this->data['name'] = $this->name;
		if ($this->form) $this->data['form'] = $this->form;
		if ($this->customForm) $this->data['customForm'] = $this->customForm->toArray();
		if ($this->document) $this->data['document'] = $this->document->toArray();
		if ($this->phone) $this->data['phone'] = $this->phone;
		if ($this->isAnonym) $this->data['isAnonym'] = $this->isAnonym;
		if ($this->save) $this->data['save'] = $this->save;
		if ($this->inn) $this->data['inn'] = $this->inn;
		if ($this->juridicalAddress) $this->data['juridicalAddress'] = $this->juridicalAddress->toArray();

		return $this->data;
	}
}
