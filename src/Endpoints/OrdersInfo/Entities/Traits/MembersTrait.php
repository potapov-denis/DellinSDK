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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities\Traits;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities\Member;
use Yooogi\DellinSDK\Instantiator;

trait MembersTrait
{
	use DataAware;

	private Member $sender;
	private Member $receiver;
	private Member $payer;

	/**
	 * Информация об отправителе
	 *
	 * @return Member
	 */
	public function getSender(): Member
	{
		return Instantiator::instantiate(Member::class, $this->get('sender'));
	}

	/**
	 * Информация о получателе
	 *
	 * @return Member
	 */
	public function getReceiver(): Member
	{
		return Instantiator::instantiate(Member::class, $this->get('receiver'));
	}

	/**
	 * Информация о плательщике
	 *
	 * @return Member
	 */
	public function getPayer(): Member
	{
		return Instantiator::instantiate(Member::class, $this->get('payer'));
	}

}