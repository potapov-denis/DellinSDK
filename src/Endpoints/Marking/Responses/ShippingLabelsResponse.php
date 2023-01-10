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

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\Marking\Responses;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Enum\ShippingLabelFormat;
use Yooogi\DellinSDK\Enum\ShippingLabelMimeType;

abstract class ShippingLabelsResponse
{
	use DataAware, MetaData;

	private ?ShippingLabelFormat $format;
	private ?ShippingLabelMimeType $type;
	private ?string $base64;


	/**
	 * Размер этикеток.
	 *
	 * Возможные значения: 80x50, a4
	 *
	 * @return ShippingLabelFormat|null
	 */
	public function getFormat(): ?ShippingLabelFormat
	{
		return ($this->get('format')) ? ShippingLabelFormat::TryFrom($this->get('format')) : null;
	}

	/**
	 * MIME-тиф файла.
	 *
	 * Возможные значения: image/jpeg, application/pdf, image/png
	 *
	 * @return ShippingLabelMimeType|null
	 */
	public function getType(): ?ShippingLabelMimeType
	{
		return ($this->get('type')) ? ShippingLabelMimeType::TryFrom($this->get('type')) : null;
	}

	/**
	 * Base64-код файла, содержащего этикетку
	 *
	 * @return string|null
	 */
	public function getBase64(): ?string
	{
		return (string)$this->get('base64');
	}

	public function toArray(): array
	{
		return $this->data;
	}
}