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

use DateTimeImmutable;
use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities\Traits\{FreightTrait, MembersTrait, PaymentTrait};
use Yooogi\DellinSDK\Entities\{OrderDates};
use Yooogi\DellinSDK\Enum\DetailedStatus;
use Yooogi\DellinSDK\Enum\Statuses;
use Yooogi\DellinSDK\Instantiator;

/**
 * Информация о заказах
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header11
 */
final class Order
{
	use DataAware, MembersTrait, FreightTrait, PaymentTrait;

	private string $orderNumber;
	private string $orderDate;
	private string $orderId;
	private string $orderedAt;
	private string $state;
	private string $stateName;
	private ?DateTimeImmutable $stateDate;
	private int $progressPercent;
	private bool $isAir;
	private DerivalArrival $derival;
	private DerivalArrival $arrival;
	private AirArrival $air;
	private ?array $locks;
	private bool $isPaid;
	private bool $isPreorder;
	private DateTimeImmutable $produceDate;
	private ?string $declineReason;
	private ?OrderDates $orderDates;
	private OrderTimeInDays $orderTimeInDays;
	private bool $orderedDeliveryFromAddress;
	private bool $availableDeliveryFromAddress;
	private bool $orderedDeliveryToAddress;
	private bool $availableDeliveryToAddress;
	private bool $isFavorite;
	private bool $isContainer;
	private Sfrequest $sfrequest;
	private array $acceptanceActs;
	private ?OrderDatesAdditional $orderDatesAdditional;
	private ?Documents $documents;
	private ?DetailedStatus $detailedStatus;
	private string $detailedStatusRus;
	private string $note;
	private ?DateTimeImmutable $documentsReturnDate;
	private ?string $priceComment;
	private ?string $customerUid;

	/**
	 * Номер заказа интернет-магазина (внутренний номер заказа, ВНЗ)
	 *
	 * @return string
	 */
	public function getOrderNumber(): string
	{
		return $this->get('orderNumber');
	}

	/**
	 * Дата заказа интернет-магазина
	 *
	 * @return string
	 */
	public function getOrderDate(): string
	{
		return $this->get('orderDate');
	}

	/**
	 * Номер заказа
	 *
	 * @return string
	 */
	public function getOrderId(): string
	{
		return $this->get('orderId');
	}

	/**
	 *    Дата создания заказа
	 *
	 * @return DateTimeImmutable|false
	 */
	public function getOrderedAt(): DateTimeImmutable|bool
	{
		return DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->get('orderedAt'));
	}

	/**
	 * Статус заказа на русском языке (см. справочник 'Справочник статусов заказа груза')
	 *
	 * @return string
	 */
	public function getStateName(): string
	{
		return $this->get('stateName');
	}

	/**
	 * Дата установки текущего статуса.
	 *
	 * Формат: 'ГГГГ-ММ-ДД'.
	 *
	 * Если статус заказа - черновик (значение параметра ответа 'orders.state' - 'draft'), то значение параметра - null
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getStateDate(): ?DateTimeImmutable
	{
		return $this->get('stateDate')
			? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('stateDate'))
			: null;
	}

	/**
	 * Степень выполнения заказа (в процентах). Значение параметра может быть использовано для визуализации хода выполнения заказа
	 *
	 * @return int|null
	 */
	public function getProgressPercent(): ?int
	{
		return $this->get('progressPercent');
	}

	/**
	 * Признак авиаперевозки
	 *
	 * @return bool
	 */
	public function isAir(): bool
	{
		return $this->get('isAir');
	}

	/**
	 * Информация о доставке авиатранспортом
	 *
	 * Если значение параметра 'isAir' - 'false', то вложенные параметры переданы не будут
	 *
	 * @return AirArrival
	 */
	public function getAir(): AirArrival
	{
		return Instantiator::instantiate(AirArrival::class, $this->get('air'));
	}


	/**
	 * Информация о месте отправки
	 *
	 * @return DerivalArrival
	 */
	public function getDerival(): DerivalArrival
	{
		return Instantiator::instantiate(DerivalArrival::class, $this->get('derival'));
	}

	/**
	 * Информация о месте получения
	 *
	 * @return DocumentDerivalArrival
	 */
	public function getArrival(): DerivalArrival
	{
		return Instantiator::instantiate(DerivalArrival::class, $this->get('arrival'));
	}

	/**
	 * Статус заказа на английском языке (см. справочник 'Справочник статусов заказа груза')
	 *
	 * Получение статуса обработки запроса
	 * @return ?Statuses
	 */
	public function getState(): ?Statuses
	{
		return Statuses::TryFrom($this->get('state'));
	}

	/**
	 * Массив блокировок по заказу
	 *
	 * @return Locks[]|null
	 */
	public function getLocks(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(Locks::class), $this->get('locks'));
	}

	/**
	 * Статус оплаты заказа
	 *
	 * @return bool
	 */
	public function isPaid(): bool
	{
		return (bool)$this->get('isPaid');
	}

	/**
	 * Флаг обозначающий, что заказ является предзаказом
	 *
	 * @return bool
	 */
	public function isPreorder(): bool
	{
		return (bool)$this->get('isPreorder');
	}

	/**
	 * Дата выполнения заказа
	 *
	 * Данные недоступны при заказе услуги 'Мультиотправка'
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getProduceDate(): ?DateTimeImmutable
	{
		return $this->get('produceDate')
			? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('produceDate'))
			: null;
	}

	/**
	 * Причина отклонения
	 *
	 * Данные доступны, только если заказ был отклонён
	 *
	 * @return string|null
	 */
	public function getDeclineReason(): ?string
	{
		return $this->get('declineReason');
	}

	/**
	 * @return OrderDates|null
	 */
	public function getOrderDates(): ?OrderDates
	{
		return Instantiator::instantiate(OrderDates::class, $this->get('orderDates'));
	}

	/**
	 * Расчетные сроки доставки от терминала до адреса в днях
	 *
	 * Данные доступны, если значение параметра 'isAir' = 'false'.
	 * В противном случае значения всех вложенных параметров данного объекта будут содержать 'null'
	 *
	 * @return OrderTimeInDays
	 */
	public function getOrderTimeInDays(): OrderTimeInDays
	{
		return Instantiator::instantiate(OrderTimeInDays::class, $this->get('orderTimeInDays'));
	}

	/**
	 * Флаг, обозначающий что заказана доставка от адреса отправителя
	 *
	 * @return bool
	 */
	public function isOrderedDeliveryFromAddress(): bool
	{
		return (bool)$this->get('orderedDeliveryFromAddress');
	}

	/**
	 * Флаг, обозначающий что возможна доставка от адреса отправителя
	 *
	 * @return bool
	 */
	public function isAvailableDeliveryFromAddress(): bool
	{
		return (bool)$this->get('availableDeliveryFromAddress');
	}

	/**
	 * Флаг, обозначающий, что заказана доставка до адреса получателя
	 *
	 * @return bool
	 */
	public function isOrderedDeliveryToAddress(): bool
	{
		return (bool)$this->get('orderedDeliveryToAddress');
	}

	/**
	 * Флаг, обозначающий, что возможна доставка до адреса получателя
	 *
	 * @return bool
	 */
	public function isAvailableDeliveryToAddress(): bool
	{
		return (bool)$this->get('availableDeliveryToAddress');
	}

	/**
	 * Признак избранного заказа
	 *
	 * @return bool
	 */
	public function isFavorite(): bool
	{
		return (bool)$this->get('isFavorite');
	}

	/**
	 * Флаг контейнерной перевозки
	 *
	 * @return bool
	 */
	public function isContainer(): bool
	{
		return (bool)$this->get('isContainer');
	}

	/**
	 * Информация по заявке на доставку до адреса получателя
	 *
	 * @return Sfrequest|null
	 */
	public function getSfrequest(): ?Sfrequest
	{
		return Instantiator::instantiate(Sfrequest::class, $this->get('sfrequest'));
	}


	/**
	 * Счета-фактуры
	 *
	 * @return AcceptanceActs[]
	 */
	public function getAcceptanceActs(): array
	{
		return Instantiator::instantiate(new ArrayOf(AcceptanceActs::class), $this->get('acceptanceActs'));
	}

	/**
	 * Информация о промежуточных точках маршрута перевозки
	 *
	 * Параметр отсутствует в ответе, если заказ отклонён или с момента завершения заказа прошло более 24 часов
	 * (значение параметра 'response.state' - 'declined' или же значение параметра 'response.state' изменилось на 'finished' более 24 часов назад)
	 *
	 * @return OrderDatesAdditional|null
	 */
	public function getOrderDatesAdditional(): ?OrderDatesAdditional
	{
		return Instantiator::instantiate(OrderDatesAdditional::class, $this->get('orderDatesAdditional'));
	}

	/**
	 * Массив документов заказа
	 *
	 * @return Documents[]|null
	 */
	public function getDocuments(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(Documents::class), $this->get('documents'));
	}

	/**
	 * Дополнительный статус заказа на английском языке.
	 *
	 * @return DetailedStatus|null
	 */
	public function getDetailedStatus(): ?DetailedStatus
	{
		if ($this->get('detailedStatus') !== null) return DetailedStatus::TryFrom($this->get('detailedStatus'));
		return $this->get('detailedStatus');
	}

	/**
	 * Дополнительный статус заказа на русском языке.
	 *
	 * @return string|null
	 */
	public function getDetailedStatusRus(): ?string
	{
		return $this->get('detailedStatusRus');
	}

	/**
	 * Комментарий к заказу.
	 *
	 * Пользователь может оставить комментарий к заказу в личном кабинете на сайте компании 'Деловых Линии'
	 *
	 * @return string|null
	 */
	public function getNote(): ?string
	{
		return (string)$this->get('note');
	}

	/**
	 * Ориентировочная дата возврата сопроводительных документов.
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getDocumentsReturnDate(): ?DateTimeImmutable
	{
		return DateTimeImmutable::createFromFormat('Y-m-d', $this->get('documentsReturnDate'));
	}

	/**
	 * Комментарий, свидетельсвующий о том, что информация о стоимости заказа недоступна текущему пользователю
	 *
	 * @return string|null
	 */
	public function getPriceComment(): ?string
	{
		return $this->get('priceComment');
	}

	/**
	 * UID заказчика по заявке
	 *
	 * Данные присутствуют в ответе, только если у пользователя есть полный доступ к контрагенту
	 * (см. метод 'Список контрагентов', описание параметра ответа 'info.accessLevel')
	 *
	 * @return string|null
	 */
	public function getCustomerUid(): ?string
	{
		return $this->get('customerUid');
	}


	public function toArray(): array
	{
		return $this->data;
	}
}
