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

final class Time implements Arrayable
{
	use DataAware;

	private string $worktimeStart;
	private string $worktimeEnd;
	private string $breakStart;
	private string $breakEnd;
	private bool $exactTime;

	/**
	 * @param string $worktimeStart Начало периода передачи груза
	 * @param string $worktimeEnd Конец периода передачи груза
	 * @param string|null $breakStart Начало периода перерыва
	 * @param string|null $breakEnd Окончания периода перерыва
	 * @param bool $exactTime Точное время подачи
	 */
	public function __construct(string $worktimeStart, string $worktimeEnd, ?string $breakStart = null, ?string $breakEnd = null, bool $exactTime = false)
	{
		$this->setWorktimeStart($worktimeStart);
		$this->setWorktimeEnd($worktimeEnd);
		$this->setBreakStart($breakStart);
		$this->setBreakEnd($breakEnd);
		$this->setExactTime($exactTime);

	}

	/**
	 * @param string $worktimeStart Начало периода передачи груза
	 * @param string $worktimeEnd Конец периода передачи груза
	 * @param string|null $breakStart Начало периода перерыва
	 * @param string|null $breakEnd Окончания периода перерыва
	 * @param bool $exactTime Точное время подачи
	 *
	 * @return static
	 */
	public static function create($worktimeStart, $worktimeEnd, $breakStart = null, $breakEnd = null, $exactTime = false): self
	{
		return new self(...func_get_args());
	}

	/**
	 * Получение начала периода передачи груза.
	 *
	 * Формат: 'ЧЧ:ММ'
	 * @return string
	 */
	public function getWorktimeStart(): ?string
	{
		return $this->get('worktimeStart');
	}

	/**
	 * Установка начала периода передачи груза.
	 *
	 * Формат: 'ЧЧ:ММ'
	 *
	 * @param string $worktimeStart
	 */
	public function setWorktimeStart(string $worktimeStart): void
	{
		$this->data['worktimeStart'] = $worktimeStart;
	}

	/**
	 * Получение окончание периода передачи груза.
	 *
	 * Формат: 'ЧЧ:ММ'
	 * @return string
	 */
	public function getWorktimeEnd(): ?string
	{
		return $this->get('worktimeEnd');
	}

	/**
	 * Установка окончания периода передачи груза.
	 *
	 * Формат: 'ЧЧ:ММ'
	 *
	 * @param string $worktimeEnd
	 */
	public function setWorktimeEnd(string $worktimeEnd): void
	{
		$this->data['worktimeEnd'] = $worktimeEnd;
	}

	/**
	 * Получение начала перерыва.
	 *
	 * Формат: 'ЧЧ:ММ'
	 * @return string
	 */
	public function getBreakStart(): ?string
	{
		return $this->get('breakStart');
	}

	/**
	 * Установка  начала перерыва.
	 *
	 * Формат: 'ЧЧ:ММ'
	 *
	 * @param string|null $breakStart
	 */
	public function setBreakStart(?string $breakStart): void
	{
		$this->data['breakStart'] = $breakStart;
	}

	/**
	 * Получение окончания перерыва.
	 *
	 * Формат: 'ЧЧ:ММ'
	 * @return string
	 */
	public function getBreakEnd(): ?string
	{
		return $this->get('breakEnd');
	}

	/**
	 * Установка окончания перерыва.
	 *
	 * Формат: 'ЧЧ:ММ'
	 *
	 * @param string|null $breakEnd
	 */
	public function setBreakEnd(?string $breakEnd): void
	{
		$this->data['breakEnd'] = $breakEnd;
	}

	/**
	 * Получение статуса передачи груза в точное время.
	 *
	 * @return bool
	 */
	public function isExactTime(): ?bool
	{
		return $this->get('exactTime');
	}

	/**
	 * Установка передачи груза в точное время.
	 *
	 * @param bool $exactTime
	 */
	public function setExactTime(bool $exactTime): void
	{
		$this->data['exactTime'] = $exactTime;
	}


	public function toArray(): array
	{
		return $this->data;
	}
}
