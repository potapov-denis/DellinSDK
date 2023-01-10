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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Enum\PrintModeType;

/**
 * Сервис позволяет получить печатные формы и скан-копии документов.
 *
 * @see https://dev.dellin.ru/api/orders/print/#_header2
 */
final class OrderPrintDocumentsRequest implements Arrayable
{
	use DataAware, Login;

	/** @var string $docUid UID накладной / накладной, с который связаны счёт / счёт фактура / накладная на выдачу. */
	private string $docUid;

	/** @var PrintModeType $mode Тип формы документа */
	private PrintModeType $mode;

	/**
	 * Запрос на печать документов
	 *
	 * @param string $docUid UID документа
	 * @param PrintModeType $mode Тип формы документа
	 */
	public function __construct(string $docUid, PrintModeType $mode)
	{
		$this->setDocUid($docUid);
		$this->setMode($mode);
	}

	public static function create(string $docUid, PrintModeType $mode)
	{
		return new self(...\func_get_args());
	}

	/**
	 * Получить UID документа
	 *
	 * @return string
	 */
	public function getDocUid(): string
	{
		return $this->docUid;
	}

	/**
	 * Установить UID документа
	 *
	 * @param string $docUid
	 */
	public function setDocUid(string $docUid): void
	{
		$this->docUid = $docUid;
	}

	/**
	 * Получить тип формы документа
	 *
	 * @return PrintModeType
	 */
	public function getMode(): PrintModeType
	{
		return $this->mode;
	}

	/**
	 * Задать тип формы документа.
	 *
	 * Возможные значения:
	 *
	 * 'bill' - счёт;
	 * 'order' - накладная;
	 * 'invoice' - счёт-фактура;
	 * 'giveout' - накладная на выдачу
	 *
	 * @param PrintModeType $mode
	 */
	public function setMode(PrintModeType $mode): void
	{
		$this->mode = $mode;
	}


	public function toArray(): array
	{
		$this->data['docuid'] = $this->docUid;
		$this->data['mode'] = $this->mode->value;

		return $this->data;
	}

}
