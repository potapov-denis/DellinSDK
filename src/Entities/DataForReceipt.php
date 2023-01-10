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

final class DataForReceipt implements Arrayable
{
	use DataAware;

	/** @var bool */
	private bool $send;
	/** @var string */
	private ?string $phone = null;
	/** @var string */
	private ?string $email = null;

	/**
	 * Контактные данные для отправки электронного чека плательщику-физическому лицу
	 * Параметр обязателен для контрагента-физического лица, являющегося плательщиком и не являющегося 'анонимным' получателем. Для контрагента-'анонимного' получателя и для
	 * контрагента-юридического лица параметр не является обязательным и игнорируется (1)
	 *
	 * @param bool $send Согласие на получение электронного чека об оплате. Доступные значения:
	 * 'true' - пользователь ввел 'phone' и/или 'email' для отправки чека;
	 * 'false' - пользователь отказался предоставлять контактные данные для отправки чека
	 * @param ?string $phone Номер телефона для отправки чека.
	 * Формат номера: '+79XXXXXXXXX' (12 символов: начинается с '+79', и далее 9 цифр)
	 * Если 'send' = 'true', то обязательна передача хотя бы одного из параметров: 'phone' или 'email'
	 * Если 'send' = 'false', то параметр игнорируется
	 * @param ?string $email Email адрес для отправки чека
	 * Если 'send' = 'true', то обязательна передача хотя бы одного из параметров: 'phone' или 'email'
	 * Если 'send' = 'false', то параметр игнорируется
	 */
	public function __construct(bool $send, ?string $phone = null, ?string $email = null)
	{
		$this->setSend($send);
		$this->setPhone($phone);
		$this->setEmail($email);
	}

	/**
	 * Контактные данные для отправки электронного чека плательщику-физическому лицу
	 * Параметр обязателен для контрагента-физического лица, являющегося плательщиком и не являющегося 'анонимным' получателем. Для контрагента-'анонимного' получателя и для
	 * контрагента-юридического лица параметр не является обязательным и игнорируется (1)
	 *
	 * @param bool $send Согласие на получение электронного чека об оплате. Доступные значения:
	 * 'true' - пользователь ввел 'phone' и/или 'email' для отправки чека;
	 * 'false' - пользователь отказался предоставлять контактные данные для отправки чека
	 * @param ?string $phone Номер телефона для отправки чека.
	 * Формат номера: '+79XXXXXXXXX' (12 символов: начинается с '+79', и далее 9 цифр)
	 * Если 'send' = 'true', то обязательна передача хотя бы одного из параметров: 'phone' или 'email'
	 * Если 'send' = 'false', то параметр игнорируется
	 * @param ?string $email Email адрес для отправки чека
	 * Если 'send' = 'true', то обязательна передача хотя бы одного из параметров: 'phone' или 'email'
	 * Если 'send' = 'false', то параметр игнорируется
	 */
	public static function create(bool $send, ?string $phone = null, ?string $email = null): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return bool
	 */
	public function isSend(): bool
	{
		return $this->send;
	}

	/**
	 * @param bool $send
	 */
	public function setSend(bool $send): DataForReceipt
	{
		$this->send = $send;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone(): ?string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone(?string $phone): DataForReceipt
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(?string $email): DataForReceipt
	{
		$this->email = $email;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['send'] = $this->send;
		if ($this->phone) $this->data['phone'] = $this->phone;
		if ($this->email) $this->data['email'] = $this->email;
		return $this->data;
	}
}
