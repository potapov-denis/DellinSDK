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

namespace Yooogi\DellinSDK\Endpoints\Authorization\Requests;


use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\DellinClient;

final class AuthRequest implements Arrayable
{
	use DataAware;

	private string $login;
	private string $password;

	/**
	 * @param string $login Логин пользователя
	 * @param string $password Пароль Пользователя
	 */
	public function __construct(string $login, string $password)
	{
		$this->setLogin($login);
		$this->setPassword($password);
	}

	/**
	 * Создать авторизацию
	 *
	 * @param string $login Логин пользователя
	 * @param string $password Пароль Пользователя
	 *
	 * @return static
	 */
	public static function create(string $login, string $password): self
	{
		return new self(...func_get_args());
	}

	/**
	 * Логин от Личного кабинета (1).
	 *
	 * В качестве логина можно использовать как email, так и номер телефона.
	 *
	 * Формат номера телефона: '+7XXXXXXXXXX' - 12 символов, начиная с '+7'
	 *
	 * @return string
	 */
	public function getLogin(): string
	{
		return $this->login;
	}

	/**
	 * Логин от Личного кабинета (1).
	 *
	 * В качестве логина можно использовать как email, так и номер телефона.
	 *
	 * Формат номера телефона: '+7XXXXXXXXXX' - 12 символов, начиная с '+7'
	 *
	 *
	 * @param string $login
	 */
	public function setLogin(string $login): void
	{
		$this->login = $login;
	}

	/**
	 * Пароль от Личного кабинета
	 *
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * Пароль от Личного кабинета
	 *
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}


	public function toArray(): array
	{
		$this->data['login'] = $this->login;
		$this->data['password'] = $this->password;
		$this->data['appkey'] = DellinClient::$appkey;
		return $this->data;
	}

}
