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
use Yooogi\DellinSDK\Enum\RequesterType;

final class Requester implements Arrayable
{
	use DataAware;

	/** @var RequesterType $role Роль в перевозке.
	 *
	 * Доступные значения:
	 *
	 * 'sender' - отправитель;
	 * 'receiver' - получатель;
	 * 'payer' - плательщик;
	 * 'third' - третье лицо
	 */
	private RequesterType $role;
	/** @var ?string UID контрагента из 'Списка контрагентов' */
	private ?string $uid = null;
	/** @var ?string Email заказчика перевозки */
	private ?string $email = null;

	/**
	 * Заказчик
	 *
	 * @param RequesterType $role Роль в перевозке
	 * @param ?string $uid UID контрагента из 'Списка контрагентов'
	 * @param ?string $email Email заказчика перевозки
	 */
	public function __construct(RequesterType $role, ?string $uid = null, ?string $email = null)
	{
		$this->setRole($role);
		$this->setUid($uid);
		$this->setEmail($email);
	}

	/**
	 * Заказчик перевозки
	 *
	 * @param RequesterType $role Роль в перевозке
	 * @param ?string $uid UID контрагента из 'Списка контрагентов'
	 * @param ?string $email Email заказчика перевозки
	 *
	 * @return static
	 */
	public static function create(RequesterType $role, ?string $uid = null, ?string $email = null): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return RequesterType
	 */
	public function getRole(): RequesterType
	{
		return $this->role;
	}

	/**
	 * @param RequesterType $role
	 */
	public function setRole(RequesterType $role): Requester
	{
		$this->role = $role;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUid(): ?string
	{
		return $this->uid;
	}

	/**
	 * @param string|null $uid
	 */
	public function setUid(?string $uid): Requester
	{
		$this->uid = $uid;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * @param string|null $email
	 */
	public function setEmail(?string $email): Requester
	{
		$this->email = $email;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['role'] = $this->role->value;
		if ($this->uid) $this->data['uid'] = $this->uid;
		if ($this->email) $this->data['email'] = $this->uid;
		return $this->data;
	}
}
