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

final class WorkingHours implements Arrayable
{
	use DataAware;

	private const ALL_WEEK_DAYS =
		['mon' => 'понедельник',
			'tue' => 'вторник',
			'wed' => 'среда',
			'thu' => 'четверг',
			'fri' => 'пятница',
			'sat' => 'суббота',
			'sun' => 'воскресенье'];
	private string $monday;
	private string $tuesday;
	private string $wednesday;
	private string $thursday;
	private string $friday;
	private string $saturday;
	private string $sunday;

	/**
	 * @return string
	 */
	public function getMonday(): string
	{
		return $this->get('mon');
	}

	/**
	 * @return string
	 */
	public function getTuesday(): string
	{
		return $this->get('tue');
	}

	/**
	 * @return string
	 */
	public function getWednesday(): string
	{
		return $this->get('wed');
	}

	/**
	 * @return string
	 */
	public function getThursday(): string
	{
		return $this->get('thu');
	}

	/**
	 * @return string
	 */
	public function getFriday(): string
	{
		return $this->get('fri');
	}

	/**
	 * @return string
	 */
	public function getSaturday(): string
	{
		return $this->get('sat');
	}

	/**
	 * @return string
	 */
	public function getSunday(): string
	{
		return $this->get('sun');
	}


	public function printAllWeekDays(): void
	{
		array_walk($this->data, static function ($value, $key) {
			echo self::ALL_WEEK_DAYS[$key] . ": {$value}\n";
		});
	}

	public function toArray(): array
	{
		return $this->data;
	}
}
