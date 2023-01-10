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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Responses;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\MetaData;

/**
 * Сервис позволяет получить печатные формы и скан-копии документов.
 *
 * @see https://dev.dellin.ru/api/orders/print/#_header6
 */
final class OrderPrintDocumentsResponse
{
	use DataAware, MetaData;

	private ?string $uid;
	private ?string $base64;
	private array $url;

	/**
	 * UID документа
	 *
	 * @return string|null
	 */
	public function getUid(): ?string
	{
		return $this->get('uid');
	}

	/**
	 * Pdf-документ в формате base64
	 *
	 * @return string|null
	 */
	public function getBase64(): ?string
	{
		return $this->get('base64');
	}

	/**
	 * Ссылка для скачивания документа. Ссылка доступна только для накладных на выдачу (значение параметра запроса 'mode' - 'giveout')
	 *
	 * @return array
	 */
	public function getUrl(): array
	{
		return (array)$this->get('url');
	}

	public function toArray(): array
	{
		return $this->data;
	}
}
