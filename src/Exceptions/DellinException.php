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


namespace Yooogi\DellinSDK\Exceptions;

use Exception;
use InvalidArgumentException;
use Throwable;
use Yooogi\DellinSDK\Endpoints\Authorization\Exceptions\AuthException;
use Yooogi\DellinSDK\Endpoints\Authorization\Exceptions\SessionInfoException;
use Yooogi\DellinSDK\Endpoints\Book\Exceptions\BookCounterAgentsException;
use Yooogi\DellinSDK\Endpoints\Calculations\Exceptions\CalculationException;
use Yooogi\DellinSDK\Endpoints\Calculations\Exceptions\CompatibleException;
use Yooogi\DellinSDK\Endpoints\Calculations\Exceptions\DeliveryException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\AddFavoriteOrderException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\CancelDeliveryException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\CancelPickUpException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\ChangeAvailableException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\ChangeContactsException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\ChangeDeliveryException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\ChangePayerException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\ChangePickUpException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\ChangeReceiverException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\DeleteFavoriteOrderException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\RepeatOrderException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\ResumeOrderException;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Exceptions\SuspendOrderException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetAcDocShippingLabelsException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetCargoStatusesException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetHandlingMarksCatalogException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetHandlingMarksException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetPackagingMarksCatalogException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetPackagingMarksException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetShippingLabelsException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\MakeShippingLabelsException;
use Yooogi\DellinSDK\Endpoints\Orders\Exceptions\MultiOrderException;
use Yooogi\DellinSDK\Endpoints\Orders\Exceptions\OrderException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderHistoryException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderPrintDeliveryException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderPrintDocumentsException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderPrintPickUpException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderSearchException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrdersLogException;
use Yooogi\DellinSDK\Endpoints\Services\Exceptions\AvailablePackagesException;
use Yooogi\DellinSDK\Endpoints\Services\Exceptions\ConditionsException;
use Yooogi\DellinSDK\Endpoints\Services\Exceptions\DeliveryDatesException;
use Yooogi\DellinSDK\Endpoints\Services\Exceptions\DispatchDatesException;
use Yooogi\DellinSDK\Endpoints\Services\Exceptions\SenderCounteragentException;
use Yooogi\DellinSDK\Endpoints\Services\Exceptions\TerminalDatesException;
use Yooogi\DellinSDK\Endpoints\Services\Exceptions\TimeIntervalException;

abstract class DellinException extends InvalidArgumentException implements \Yooogi\DellinSDK\Contracts\DellinException
{
	protected const ERRORS = [
		ChangeContactsException::class => 'Не удалось изменить контактные данные.',
		ChangeAvailableException::class => 'Не удалось получить доступные изменения.',
		ChangePayerException::class => 'Не удалось изменить плательщика.',
		ChangeReceiverException::class => 'Не удалось изменить получателя.',
		DispatchDatesException::class => 'Не удалось получить информацию об доступных датах отправки.',
		AuthException::class => 'Не удалось авторизоваться.',
		CalculationException::class => 'Не удалось выполнить расчет.',
		RepeatOrderException::class => 'Не удалось создать повтор заказа.',
		OrderException::class => 'Не удалось создать заказ.',
		OrderHistoryException::class => 'Не удалось получить историю заказа.',
		OrderPrintDeliveryException::class => 'Не удалось получить печатные формы на отвоз.',
		OrderPrintDocumentsException::class => 'Не удалось получить печатные формы для документов.',
		OrderPrintPickUpException::class => 'Не удалось получить печатные формы на забор.',
		OrderSearchException::class => 'Не удалось выполнить поиск заказов.',
		AvailablePackagesException::class => 'Не удалось получить информацию об доступных типах упаковки.',
		ConditionsException::class => 'Не удалось получить информацию об ограничениях и возможных значениях параметров.',
		DeliveryDatesException::class => 'Не удалось получить информацию об доступных датах доставки.',
		OrdersLogException::class => 'Не удалось получить журнал заказов.',
		SenderCounteragentException::class => 'Не удалось получить контрагента.',
		TimeIntervalException::class => 'Не удалось получить информацию об доступных интервалах.',
		CompatibleException::class => 'Указаны несовместимые типы погрузки.',
		ChangePickUpException::class => 'Не удалось изменить адрес и время отправки.',
		ChangeDeliveryException::class => 'Не удалось изменить адрес и время доставки.',
		CancelPickUpException::class => 'Не удалось отменить доставку от адреса отправителя.',
		CancelDeliveryException::class => 'Не удалось отменить доставку до адреса получателя.',
		SuspendOrderException::class => 'Не удалось приостановить выдачу заказа.',
		ResumeOrderException::class => 'Не удалось возобновить выдачу заказа.',
		AddFavoriteOrderException::class => 'Не удалось добавить заказ в избранные.',
		DeleteFavoriteOrderException::class => 'Не удалось удалить заказ из избранного.',
		SessionInfoException::class => 'Не удалось получить информацию по сессии.',
		DeliveryException::class => 'Не удалось рассчитать стоимость доставки до адреса.',
		BookCounterAgentsException::class => 'Не удалось получить контрагентов из адресной книги.',
		MakeShippingLabelsException::class => 'Не удалось создать этикетки к грузоместам.',
		GetShippingLabelsException::class => 'Не удалось получить этикетки к грузоместам.',
		GetAcDocShippingLabelsException::class => 'Не удалось получить этикетки к сопроводительным документам.',
		GetCargoStatusesException::class => 'Не удалось получить статусы грузомест.',
		GetHandlingMarksCatalogException::class => 'Не удалось получить справочник этикеток с манипуляционными знаками.',
		GetHandlingMarksException::class => 'Не удалось получить этикетки с манипуляционными знаками.',
		GetPackagingMarksCatalogException::class => 'Не удалось получить справочник этикеток упаковок.',
		GetPackagingMarksException::class => 'Не удалось получить этикетки типа упаковки.',
		TerminalDatesException::class => 'Не удалось получить даты отгрузки на терминал.',
		MultiOrderException::class => 'Не удалось оформить мультзаявку.'
	];
	protected static ?Throwable $exception;

	/**
	 * Описание ошибок
	 *
	 * @return void
	 */
	public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
		static::$exception = new Exception($message, $code, $previous);
	}

	public static function printMessages(): void
	{
		foreach (static::getMessages() as $error) {
			echo $error . PHP_EOL;
		}
	}

	public static function getMessages(): array
	{
		do {
			$errors[] = static::$exception->getMessage();
		} while (static::$exception = static::$exception->getPrevious());
		return $errors;
	}

	public static function getExceptionMessage(): string
	{
		return self::ERRORS[static::class] ?? 'Ошибка.';
	}
}