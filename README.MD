# PHP SDK для Деловых Линий

![alt text](https://app.dellin-ms.yooogi.ru/img/dellin_sdk.png)

# Installation

```bash
composer require yooogi/dellinsdk
```

# Configuration

```php
require_once '../vendor/autoload.php';

use GuzzleHttp\Client;
use Yooogi\DellinSDK\DellinClient;

$client = new Client();
$dellin = new DellinClient('YOUR_APP_KEY', $client);
```

PHP 8.1 or newer is required

PSR-18 Client is required

# Auth

You can use existing Auth session id:

```php
$auth = new AuthResponse('YOUR_SESSION_ID');
```

Or get new Auth session id from Dellin:

```php
$authRequest = AuthRequest::create('YOUR_DELLIN_ACCOUNT', 'YOUR_DELLIN_PASSWORD');
$auth = $dellin->authorization->auth($authRequest);
echo $auth->getSessionId();
```

To use some methods with Auth:

```php
$sessionInfoRequest = SessionInfoRequest::create('YOUR_SESSION_ID')
    ->withAuth($auth);
$sessionInfoResponse = $dellin->authorization->info($sessionInfoRequest);
```

# Examples:

## Calculation:

```php
/* Погрузочные работы */
$handling = Handling::create(false, null, null);

/* Время */
$time = Time::create('10:00', '23:00', '11:00', '12:00', false);

/* Требуемые условия погрузки */
$requirements = RequirementsCollection::create();
$requirements[] = TransportRequirements::UNCOVER;

/* Адрес */
$address = Address::create(AddressType::SEARCH, 'Москва, Малая Тульская 2/1 корп 2 кв 355');

/* Информация по месту отправителя */
$derival = DerivalArrival::create($date, TransportType::ADDRESS)
    ->setProduceDate($date)
    ->setTime($time)
    ->setRequirements($requirements)
    ->setAddress($address);
    
/* Информация по месту получателя */
$arrival = DerivalArrival::create($date, TransportType::TERMINAL)
    ->setTerminalId(6)
    ->setTime($time);

/* Упаковка */
$packages = PackageCollection::create([PackageType::BUBBLE]);
$packages->addPackage(PackageType::CRATE);
$packages->setQuantity(PackageType::BUBBLE, 1);

/* Груз */
$cargoItem = CargoItem::create(130, 0.1, 0.1, 0.2, 4000);
$cargos = CargoItemsCollection::create([$cargoItem]);
$cargo = Cargo::create($cargos)
    ->setInsurance(true)
    ->setTermInsurance(true)
    ->setPayerInsurance(PayerType::SENDER)
    ->setFreightName('Мебель');

/* Заказчик */
$requester = Requester::create(RequesterType::SENDER); 

/* Калькулятор */
$calculationRequest = CalculationRequest::create(DeliveryType::AUTO, $derival, $arrival, $cargo)
    ->setPackages($packages)
    ->setRequester($requester)
    ->withAuth($auth);
$calc = $dellin->calculations->calculate($calculationRequest);
```

## Async Calculation:

Please, use Guzzle Client 7.5

```php
$calculationResponse = $dellin->calculations->asyncCalculate(
    ['AUTO' => $calculationRequest,'AVIA' => $calculationRequest2]
);
```

## Create Order:

```php
/* Сопроводительные документы */
$acdoc = AccompanyingDocumentsCollection::create([AcDoc::SEND,
    AcDoc::RETURN]);
$acdoc->setPayer(AcDoc::SEND, PayerType::SENDER);

/* Товар */
$product = Product::create('PRODUCT_NAME', 1, 344.3)
    ->setVATRate(VATType::VAT10);

/* Наложенный платеж */
$cashOnDelivery = CashOnDelivery::create(false)
    ->setOrderNumber('1234567')
    ->setOrderDate(new DateTimeImmutable('2042-04-20'))
    ->setCashOnDeliveryPaymentType(CashOnDeliveryPaymentType::CASH)
    ->setProducts([$product]);

/* Оплата */
$payment = Payment::create(PaymentType::CASH, PayerType::SENDER);
  //->setCashOnDelivery($cashOnDelivery)



$customForm = CustomForm::create('CUSTOM_FORM_NAME', 'COUNTRY_ID', false);
$document = Document::create(DocumentType::PASSPORT, 'NUMBER', 'NUMBER');
$counterAgent = Counteragent::create('YOUR_COUNTERAGENT_ID')
    ->setDocument($document)
    ->setForm('0xa3e714bceb061db84f91842983ef5abc')
    ->setInn('YOUR_INN_NUMBER');
  //->setJuridicalAddress($address);

$phone = PhoneNumber::create('79110000000');
$contactPerson = ContactPerson::create('YOUR_CONTACT_PERSON_NAME');
$dataForReceipt = DataForReceipt::create(true)->setPhone('+79110000000');
$member = Member::create($counterAgent)
    ->setPhoneNumbers([$phone])
    ->setContactPersons([$contactPerson])
    ->setDataForReceipt($dataForReceipt);
  //->setPhoneIDs(['123123'])
  //->setContactIDs(['123132'])
  //->setCounteragentID(123);

/* Участники перевозки */
$members = Members::create($requester, $member, $member);


/* Создание заказа */
$orderRequest = OrderRequest::create(DeliveryType::AUTO, $derival, $arrival, $members, $cargo, $payment)
    ->setInOrder(false)
    ->setAccompanyingDocuments($acdoc)
    ->setPackages($packages)
    ->withAuth($auth);
$orderResponse = $dellin->orders->create($orderRequest);
```

## Get sender counteragents:

```php
/* Контрагенты отправителя */
$counterAgentRequest = SenderCounteragentsRequest::create()->setFullInfo(true)->withAuth($auth);
$getCounterAgents = $dellin->services->getCounteragents($counterAgentRequest);
$getCounterAgents->getCounteragents();
```

## Get orders log:

```php
/* Журнал заказов*/
$orderLogRequest = OrdersLogRequest::create()->setDocIds(['YOUR_REQUEST_ID'])
    ->setStates(StatusesCollection::create([Statuses::INWAY,
        Statuses::PICKUP]))
    ->setOrderDatesAdditional(true)
    ->withAuth($auth);
$getOrderLogInfo = $dellin->ordersInfo->getLog($orderLogRequest);
```

## Print request:

```php
/* Печать заявок заказу*/
$ordersPrintPickUpRequest = OrderPrintRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$ordersPrintPickUp  = $dellin->ordersInfo->printPickUp($ordersPrintPickUpRequest);
```

## Print document:

```php
/* Печать документов к заказу*/
$ordersPrintDocumentsRequest = OrderPrintDocumentsRequest::create('YOUR_DOCUMENT_UID', PrintModeType::ORDER)->withAuth($auth);
$ordersPrintDocuments = $dellin->ordersInfo->printDocuments($ordersPrintDocumentsRequest);
```

## Get order history:

```php
/* История по заказу*/
$orderHistoryRequest = OrderHistoryRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$orderHistory = $dellin->ordersInfo->getHistory($orderHistoryRequest);
```

## Search order by parameters:

```php
/* Поиск заказа по параметрам*/
$requestMember = Member::create()->setInn('INN_NUMBER');
$orderSearchRequest = OrderSearchRequest::create(new DateTimeImmutable('2022-06-15'), new DateTimeImmutable('2022-07-22'))
  ->setReceiver($requestMember)
  ->setSender($requestMember)
  ->withAuth($auth);
$orderSearch = $dellin->ordersInfo->search($orderSearchRequest);
```

## Get conditions:

```php
/* Проверка ограничений */
$conditionsRequest = ConditionsRequest::create(DeliveryType::AUTO, '7701700000000000000000000', '3400000100000000000000000',
    0.01, 1, 1, 1)
  ->setArrivalDoor(true)
  ->setDerivalDoor(true)
  ->withAuth($auth);
$conditionsResponse = $dellin->services->getConditions($conditionsRequest);
```

## Get dispatch dates:

```php
/* Даты отправления */
$dispatchDatesRequest = DispatchDateRequest::create(DeliveryType::AUTO, $derival, $cargo)->withAuth($auth);
$dispatchDatesResponse = $dellin->services->getDispatchDates($dispatchDatesRequest);
```

## Get dispatch time:

```php
/* Время отправления */
$dispatchTimeRequest = DispatchTimeRequest::create(DeliveryType::AUTO, $derival2, $cargo)->withAuth($auth);
$dispatchTimeResponse = $dellin->services->getDispatchTimeInterval($dispatchTimeRequest);

```

## Get delivery time:

```php
/* Время доставки  */
$deliveryDatesRequest = DeliveryTimeRequest::create('YOUR_REQUEST_ID', $arrival)->withAuth($auth);
$deliveryDatesResponse = $dellin->services->getDeliveryTimeInterval($deliveryDatesRequest);

```

## Get available packages:

```php
/* Доступные упаковки */
$availablePackageRequest = AvailablePackagesRequest::createFromCargo('7700000000000000000000000', '100400003400000000000000', $cargo)->withAuth($auth);
$availablePackageResponse = $dellin->services->getAvailablePackages($availablePackageRequest);
```

## Repeat order:

```php
/* Повтор заказа */
$repeatOrderRequest = RepeatOrderRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$repeatOrderResponse = $dellin->manageOrders->repeatOrder($repeatOrderRequest);
```

## Available changes for order:

```php
/* Доступные изменения */
$changeAvailableRequest = ChangeAvailableRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$changeAvailableResponse = $dellin->manageOrders->getChangeAvailable($changeAvailableRequest);
```

## Change receiver:

```php
/* Изменение получателя */
$changeReceiverRequest = ChangeReceiverRequest::create('YOUR_REQUEST_ID', $member, true, PayerType::RECEIVER)->withAuth($auth);
$changeReceiverResponse = $dellin->manageOrders->changeReceiver($changeReceiverRequest);
```

## Change payer:

```php
/* Изменение плательщика */
$changePayerRequest = ChangePayerRequest::create('YOUR_REQUEST_ID', third: $counterAgent, member: $member)->withAuth($auth);
$changePayerResponse = $dellin->manageOrders->changePayer($changePayerRequest);

```

## Change contact data:

```php
/* Изменение контактных данных*/
$changeContactsRequest = ChangeContactsRequest::create('YOUR_REQUEST_ID', $members)->withAuth($auth);
$changeContactsResponse = $dellin->manageOrders->changeContacts($changeContactsRequest);
```

## Change address and time of dispatch:

```php
/* Изменение адреса и времени отправки */
$changePickUpRequest = ChangePickUpRequest::create('YOUR_REQUEST_ID', $derival, $member)->withAuth($auth);
$changePickUpResponse = $dellin->manageOrders->changePickUp($changePickUpRequest);

```

## Change address and time of delivery:

```php
/* Изменение адреса и времени доставки  */
$changeDeliveryRequest = ChangeDeliveryRequest::create('YOUR_REQUEST_ID', $arrival, $members, RequesterType::PAYER)->withAuth($auth);
$changeDeliveryResponse = $dellin->manageOrders->changeDelivery($changeDeliveryRequest);
```

## Cancel pickup:

```php
/* Отмена доставки от адреса отправителя */
$cancelPickUpRequest = CancelRequest::create('YOUR_REQUEST_ID', $member)->withAuth($auth);
$cancelPickUpResponse = $dellin->manageOrders->cancelPickUp($cancelPickUpRequest);
```

## Cancel delivery:

```php
/* Отмена доставки до адреса отправителя */
$cancelDeliveryRequest = CancelDeliveryRequest::create('YOUR_REQUEST_ID', $member, RequesterType::CUSTOMER)->withAuth($auth);
$cancelDeliveryResponse = $dellin->manageOrders->cancelDelivery($cancelDeliveryRequest);
```

## Resume order:

```php
/* Возобновление выдачи груза */
$resumeOrderRequest = ResumeOrderRequest::create('YOUR_REQUEST_ID', new DateTimeImmutable('2022-07-30'))->withAuth($auth);
$resumeOrderResponse = $dellin->manageOrders->resumeOrder($resumeOrderRequest);

```

## Suspend Order:

```php
/* Приостановка выдачи груза */
$suspendOrderRequest = SuspendOrderRequest::create('YOUR_REQUEST_ID', new DateTimeImmutable('2022-07-30'))->withAuth($auth);
$suspendOrderResponse = $dellin->manageOrders->suspendOrder($suspendOrderRequest);
```

## Add to favorite:

```php
/* Добавление в избранное */
$addFavoriteOrderRequest = AddFavoriteOrderRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$addFavoriteOrderResponse = $dellin->manageOrders->addFavoriteOrder($addFavoriteOrderRequest);
```

## Delete from favorite

```php
/* Удаление из избранного */
$deleteFavoriteOrderRequest = DeleteFavoriteOrderRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$deleteFavoriteOrderResponse = $dellin->manageOrders->deleteFavoriteOrder($deleteFavoriteOrderRequest);
```

## Calculate delivery to address:

```php
/* Расчет стоимости доставки до адреса */
$deliveryRequest = DeliveryRequest::create('7700000000000000000000000', 'YOUR_REQUEST_ID', new DateTimeImmutable('2042-04-20'))
    ->setHandling($handling)->withAuth($auth);
$deliveryResponse = $dellin->calculations->delivery($deliveryRequest);
```

## Get counteragents from book:

```php
/* Получить контрагента из книги */
$bookCounterAgentsRequests = BookCounterAgentsRequest::create()->withAuth($auth);
$bookCounterAgents = $dellin->book->getCounterAgents($bookCounterAgentsRequests);
```

## Make markings to cargoplaces:

```php
/* Запрос на создание этикеток к местам*/
$cargoPlace = CargoPlace::create('CARGO_PLACE_NAME');
$cargoPlaces = CargoPlacesCollection::create([$cargoPlace]);
$makeShippingLabelsRequest = MakeShippingLabelsRequest::create('YOUR_REQUEST_ID', $cargoPlaces)->withAuth($auth);
$makeShippingLabelsResponse = $dellin->marking->makeShippingLabels($makeShippingLabelsRequest);
```

## Get markings to cargoplaces:

```php
/* Получение этиекток на груз*/
$getShippingLabelsRequest = GetShippingLabelsRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$getShippingLabelsResponse = $dellin->marking->getShippingLabels($getShippingLabelsRequest);
```

## Get markings to accompanying documents:

```php
/* Получение этиекток на сопроводительные документы */
$getAcDocShippingLabelsRequest = GetAcDocShippingLabelsRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$getAcDocShippingLabelsResponse = $dellin->marking->getAcDocShippingLabels($getAcDocShippingLabelsRequest);
```

## Get statuses of cargoplaces:

```php
/* Получение статусов грузомест*/
$getCargoStatusesRequest = GetCargoStatusesRequest::create('YOUR_REQUEST_ID')->withAuth($auth);
$getCargoStatusesResponse = $dellin->marking->getCargoStatuses($getCargoStatusesRequest);
```

## Get handling markings catalog:

```php
/* Получение справочника этикеток с манипуляционными знаками */
$getHandlingMarksCatalogRequest = GetHandlingMarksCatalogRequest::create()->withAuth($auth);
$getHandlingMarksCatalogResponse = $dellin->marking->getHandlingMarksCatalog($getHandlingMarksCatalogRequest);
```

## Get handling markings:

```php
/* Получение этикеток с манипуляционными знаками */
$handlingMark = HandlingMark::create(HandlingMarkName::BEACON, 2, ShippingLabelFormat::LARGE);
$getHandlingMarksRequest = GetHandlingMarksRequest::create([$handlingMark], false, ShippingLabelType::PDF)->withAuth($auth);
$getHandlingMarksResponse = $dellin->marking->getHandlingMarks($getHandlingMarksRequest);
```

## Get packaging markings catalog:

```php
/* Получение справочника этикеток с типами упаковки */
$getPackagingMarksCatalogRequest = GetPackagingMarksCatalogRequest::create()->withAuth($auth);
$getPackagingMarksCatalogResponse = $dellin->marking->getPackagingMarksCatalog($getPackagingMarksCatalogRequest);
```

## Get packaging markings:

```php
/* Получение этикеток с типами упаковки */
$packagingMark = PackagingMark::create(PackagingMarkName::CRATE, 2, ShippingLabelFormat::SMALL);
$getPackagingMarksRequest = GetPackagingMarksRequest::create([$packagingMark], true, ShippingLabelType::PDF)->withAuth($auth_test);
$getPackagingMarksResponse = $dellin->marking->getPackagingMarks($getPackagingMarksRequest);
```

Возможности:

- [x] Авторизация
    - [x] Авторизация пользователя
    - [x] Список контрагентов
- [ ] Выполнение расчета
    - [x] Калькулятор стоимости и сроков
    - [x] Калькулятор услуги Доставка
    - [ ] Ориентировочные сроки и стоимость
- [ ] Оформление заявок
    - [x] Перевозка сборных грузов
    - [ ] Междугородняя перевозка еврофурой
    - [ ] Перевозка малотоннажным транспортом
    - [ ] Почасовая аренда транспорта
    - [ ] Дополнение заказа доставкой
    - [ ] Мультизаявка
    - [ ] Пакетный заказ Pre-Alert
- [ ] Информация по заказам
    - [x] Журнал заказов
    - [x] Поиск по параметрам перевозки
    - [x] История изменений заказа
    - [x] Печатные формы
    - [ ] Отчеты
- [x] Управление заказом
    - [x] Повтор заказа
    - [x] Доступные изменения
    - [x] Изменение получателя
    - [x] Изменение плательщика
    - [x] Изменение контактной информации
    - [x] Изменение адреса и времени отправки
    - [x] Изменение адреса и времени доставки
    - [x] Отмена заказа и доставки груза
    - [x] Приостановка и возобновление выдачи
    - [x] Добавление в Избранное
- [x] Самомаркировка
    - [x] Маркировка грузовых мест
    - [x] Манипуляционные знаки
    - [x] Маркировка упаковки
- [ ] Адресная книга
    - [x] Контрагенты
    - [ ] Контактные данные
    - [ ] Адреса
    - [ ] Удаление объектов
- [ ] Платежи
    - [ ] Взаиморасчеты
    - [ ] Периоды взаиморасчётов
    - [ ] Получение ссылки на оплату
- [ ] Терминалы
    - [ ] Справочник терминалов
    - [ ] Поиск терминалов
    - [ ] Терминалы на карте
- [ ] Местоположения
    - [ ] Географические справочники
    - [ ] Поиск географических объектов
    - [ ] Поиск КЛАДР
- [ ] Справочные методы
    - [x] Подбор даты отправки
    - [x] Подбор даты доставки
    - [x] Подбор времени приезда водителя
    - [x] Проверка ограничений
    - [x] Доступные упаковки
    - [x] Параметры негабаритного груза
    - [ ] Поиск ОПФ
    - [ ] Поиск характера груза
    - [ ] Справочники
- [x] Самостоятельная маркировка груза
    - [x] Маркировка грузовых мест
    - [x] Манипуляционные знаки
    - [x] Маркировка упаковки