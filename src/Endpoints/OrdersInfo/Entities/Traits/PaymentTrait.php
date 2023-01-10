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

trait PaymentTrait
{
	use DataAware;

	private ?float $webOrderItemsSum;
	private ?float $totalSum;
	private ?float $vat;

	/**
	 * Сумма наложенного платежа
	 *
	 * Данные доступны только в том случае, если у текущей учётной записи есть полный доступ к контрагенту
	 * (см. метод 'Список контрагентов', описание параметра ответа 'info.accessLevel')
	 *
	 * @return float
	 */
	public function getWebOrderItemsSum(): float
	{
		return (float)$this->get('webOrderItemsSum');
	}

	/**
	 *    Общая сумма заказа
	 *
	 * @return float
	 */
	public function getTotalSum(): float|null
	{
		return (float)$this->get('totalSum');
	}

	/**
	 * НДС
	 *
	 * @return float
	 */
	public function getVat(): float|null
	{
		return (float)$this->get('vat');
	}

}