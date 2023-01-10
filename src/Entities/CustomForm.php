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


final class CustomForm implements Arrayable
{
	use DataAware;

	private ?string $formName;
	private ?string $countryUID;
	private ?bool $juridical;

	/**
	 * ОПФ в форме набора параметров.
	 * Передача одного из взаимоисключающих параметров 'form' или 'customForm' является обязательно.
	 * При этом параметр 'customForm' следует использовать только в том случае,
	 * если не удалось найти нужную ОПФ в справочнике
	 *
	 * @param ?string $formName Название ОПФ в текстовом формате. Максимальная длина поля: 35 символов
	 * @param ?string $countryUID UID страны, см. метод 'Поиск стран'
	 * @param ?bool $juridical Признак юридического лица
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header15
	 */
	public function __construct(?string $formName, ?string $countryUID, ?bool $juridical)
	{
		$this->setFormName($formName);
		$this->setCountryUID($countryUID);
		$this->setJuridical((bool)$juridical);

	}

	/**
	 * ОПФ в форме набора параметров.
	 * Передача одного из взаимоисключающих параметров 'form' или 'customForm' является обязательно.
	 * При этом параметр 'customForm' следует использовать только в том случае,
	 * если не удалось найти нужную ОПФ в справочнике
	 *
	 * @param ?string $formName Название ОПФ в текстовом формате. Максимальная длина поля: 35 символов
	 * @param ?string $countryUID UID страны, см. метод 'Поиск стран'
	 * @param ?bool $juridical Признак юридического лица
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header15
	 */
	public static function create(?string $formName, ?string $countryUID, ?bool $juridical): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return string|null
	 */
	public function getFormName(): ?string
	{
		return $this->formName;
	}

	/**
	 * @param string|null $formName
	 */
	public function setFormName(?string $formName): void
	{
		$this->formName = $formName;
	}

	/**
	 * @return string|null
	 */
	public function getCountryUID(): ?string
	{
		return $this->countryUID;
	}

	/**
	 * @param string|null $countryUID
	 */
	public function setCountryUID(?string $countryUID): void
	{
		$this->countryUID = $countryUID;
	}

	/**
	 * @return bool|null
	 */
	public function getJuridical(): ?bool
	{
		return $this->juridical;
	}

	/**
	 * @param bool|null $juridical
	 */
	public function setJuridical(?bool $juridical): void
	{
		$this->juridical = (bool)$juridical;
	}


	public function toArray(): array
	{
		if ($this->formName) $this->data['formName'] = $this->formName;
		if ($this->countryUID) $this->data['countryUID'] = $this->countryUID;
		if ($this->juridical) $this->data['juridical'] = $this->juridical;

		return $this->data;
	}
}
