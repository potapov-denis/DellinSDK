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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Instantiator;

/**
 * Информация о промежуточных точках маршрута перевозки
 *
 * Параметр отсутствует в ответе, если заказ отклонён или с момента завершения заказа прошло более 24 часов
 * (значение параметра 'response.state' - 'declined' или же значение параметра 'response.state' изменилось на 'finished' более 24 часов назад)
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header19
 */
class OrderDatesAdditional implements Arrayable
{

	use DataAware;

	private ?array $tracing;

	/**
	 *  Список промежуточных точек маршрута перевозки. Максимальное число элементов массива - 10.
	 *  Если промежуточных точек больше 10, то в ответе метода будет представлена информация по 10 последним точкам маршрута
	 *
	 * @return Tracing[]|null
	 */
	public function getTracing(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(Tracing::class), $this->get('tracing'));
	}


	public function toArray(): array
	{
		return $this->data;
	}
}