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

namespace Yooogi\DellinSDK\Core\Traits;


trait Pagination
{
	private ?int $per = 30;
	private ?int $page = 1;

	/**
	 * Получить количество элементов на странице
	 *
	 * Максимальное значение - 50.
	 *
	 * @return int|null
	 */
	public function getPer(): ?int
	{
		return $this->per;
	}

	/**
	 * Установить количество элементов на странице
	 *
	 * Максимальное значение - 50.
	 *
	 * @param int|null $per
	 */
	public function setPer(?int $per): self
	{
		$this->per = $per < 50 ? $per : 50;
		return $this;
	}

	/**
	 * Получить номер страницы
	 *
	 * @return int|null
	 */
	public function getPage(): ?int
	{
		return $this->page;
	}

	/**
	 * Установить номер страницы
	 *
	 * @param int|null $page
	 */
	public function setPage(?int $page): self
	{
		$this->page = $page;
		return $this;
	}

}
