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

final class Members implements Arrayable
{
	use DataAware;

	/** @var Requester $requester Заказчик перевозки */
	private Requester $requester;
	/** @var Member $sender Отправитель */
	private Member $sender;
	/** @var Member $receiver Получатель */
	private Member $receiver;
	/** @var Member ?$third Третье лицо */
	private ?Member $third = null;
	private bool $auth = false;

	/**
	 * Участники перевозки
	 *
	 * @param Requester $requester Заказчик перевозки
	 * @param Member $sender Отправитель
	 * @param Member $receiver Получатель
	 * @param ?Member $third Третье лицо
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header14
	 */
	public function __construct(Requester $requester, Member $sender, Member $receiver, ?Member $third = null)
	{
		$this->setRequester($requester);
		$this->setSender($sender);
		$this->setReceiver($receiver);
		$this->setThird($third);
	}

	/**
	 * Участники перевозки
	 *
	 * @param Requester $requester Заказчик перевозки
	 * @param Member $sender Отправитель
	 * @param Member $receiver Получатель
	 * @param ?Member $third Третье лицо
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header14
	 */
	public static function create(Requester $requester, Member $sender, Member $receiver, ?Member $third = null): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return Requester
	 */
	public function getRequester(): Requester
	{
		return $this->requester;
	}

	/**
	 * @param Requester $requester
	 */
	public function setRequester(Requester $requester): Members
	{
		$this->requester = $requester;
		return $this;
	}

	/**
	 * @return Member
	 */
	public function getSender(): Member
	{
		return $this->sender;
	}

	/**
	 * @param Member $sender
	 */
	public function setSender(Member $sender): Members
	{
		$this->sender = $sender;
		return $this;
	}

	/**
	 * @return Member
	 */
	public function getReceiver(): Member
	{
		return $this->receiver;
	}

	/**
	 * @param Member $receiver
	 */
	public function setReceiver(Member $receiver): Members
	{
		$this->receiver = $receiver;
		return $this;
	}

	/**
	 * @return Member
	 */
	public function getThird(): Member
	{
		return $this->third;
	}

	/**
	 * @param ?Member $third
	 */
	public function setThird(?Member $third): Members
	{
		$this->third = $third;
		return $this;
	}

	public function toArray(): array
	{
		$this->sender->setAuth($this->isAuth());
		$this->receiver->setAuth($this->isAuth());
		if ($this->third) $this->third->setAuth($this->isAuth());


		$this->data['requester'] = $this->requester->toArray();
		$this->data['sender'] = $this->sender->toArray();
		$this->data['receiver'] = $this->receiver->toArray();
		if ($this->third) $this->data['third'] = $this->third->toArray();

		return $this->data;
	}

	/**
	 * @return bool
	 */
	public function isAuth(): bool
	{
		return $this->auth;
	}

	/*
		* @param Requester $requester  	Заказчик перевозки
		* @param Member $sender Отправитель
		* @param Member $receiver Получатель
		* @param ?Member $third Третье лицо*/

	/**
	 * @param bool $auth
	 */
	public function setAuth(bool $auth): void
	{
		$this->auth = $auth;
	}
}
