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

namespace Yooogi\DellinSDK\Endpoints\ManageOrders;

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
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\AddFavoriteOrderRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\CancelRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\ChangeAvailableRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\ChangeContactsRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\ChangeDeliveryRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\ChangePayerRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\ChangePickUpRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\ChangeReceiverRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\DeleteFavoriteOrderRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\RepeatOrderRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\ResumeOrderRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Requests\SuspendOrderRequest;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\AddFavoriteOrderResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\CancelResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\ChangeAvailableResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\ChangeContactsResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\ChangeDeliveryResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\ChangePayerResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\ChangePickUpResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\ChangeReceiverResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\DeleteFavoriteOrderResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\RepeatOrderResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\ResumeOrderResponse;
use Yooogi\DellinSDK\Endpoints\ManageOrders\Responses\SuspendOrderResponse;
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Http\ApiClient;

final class ManageOrders
{
	/** @var ApiClient */
	private ApiClient $client;

	public function __construct(ApiClient $client)
	{
		$this->client = $client;
	}

	/**
	 * ???????????? ???????????????????????? ?????? ???????????????????? ???????????? ????????????/???????????????????? ?????????????????????? ?????????????? ??????????????????????????.
	 *
	 * @param RepeatOrderRequest $request
	 *
	 * @return RepeatOrderResponse|null
	 *
	 * @throws RepeatOrderException
	 * @see https://dev.dellin.ru/api/auth/counteragents/
	 *
	 */
	public function repeatOrder(RepeatOrderRequest $request): ?RepeatOrderResponse
	{
		try {
			return $this->client->post('/v2/request/repeat.json', $request, RepeatOrderResponse::class);
		} catch (BadRequest $e) {
			throw new RepeatOrderException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ?????????????????? ??????????????????????:
	 *
	 * - ?????????? ????????????????????;
	 * - ?????????? ??????????????????????;
	 * - ?????????????????? ?????????????? ????????????;
	 * - ?????????????????? ???????????????????? ???????????????????? ???? ????????????;
	 * - ?????????????????? ???????????? ???????????????? ?? ???????????????? ??????????;
	 * - ???????????????????????? ?? ?????????????????????????? ????????????;
	 * - ???????????? ???????????? ???? ???????????????? ???? ???????????? ??????????????????????;
	 * - ???????????? ???????????? ???? ???????????????? ???? ???????????? ???????????????????? (?????? ?????????????????? ?????????? ?????????????? ???????????????????? ?????????? ???????????????? ???? ???????????????? ???????????????? '?????????????? ??????????').
	 *
	 * @param ChangeAvailableRequest $request
	 *
	 * @return ChangeAvailableResponse|null
	 *
	 * @throws ChangeAvailableException
	 * @see https://dev.dellin.ru/api/order/check/
	 *
	 */
	public function getChangeAvailable(ChangeAvailableRequest $request): ?ChangeAvailableResponse
	{
		try {
			return $this->client->post('/v3/orders/change_available.json', $request, ChangeAvailableResponse::class);
		} catch (BadRequest $e) {
			throw new ChangeAvailableException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ???????????????? ???????????????????? ???? ?????? ???????????????????????? ????????????, ?????? ?????????????????????????? ?????????????????? ?????? ???????????????????????? ???? ????????????, ?? ?????????? ????????????????????,
	 * ?????? ?????????? ???? ???????? ?????????????? ???? ?????????????? ???????????????? - ??????????????????????, ?????????? ???????????????????? ?????? ???????????? ????????.
	 *
	 * ?????????? ???????????????????? ???????????????? ???????????? ?????????????????????? ?????? ????????????????????????,
	 * ???????????????? ???????????? ???????????? ?? ?????????????????????? (?????????????????? ?? ???????????? ?????????????? ????. ?? ???????????????? ?????????????????? ???????????? info.accessLevel ???????????? '???????????? ????????????????????????').
	 * ?????? ???????????????? ?????????????????????? ?????????????????? ???????????????????? ???? ???????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ??????????????????'.
	 *
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????. ?????????? ???????????????????????????? ???????????????? ???????????? ???? ???????????????? ?????????????????? ?????????? ???????? ???????????????? ?????? ??????????????????. ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 *
	 * @param ChangeReceiverRequest $request
	 *
	 * @return ChangeAvailableResponse|null
	 *
	 * @throws ChangeAvailableException
	 *
	 * @see https://dev.dellin.ru/api/order/change-receiver/
	 *
	 */
	public function changeReceiver(ChangeReceiverRequest $request): ?ChangeAvailableResponse
	{
		try {
			return $this->client->post('/v3/orders/change_receiver.json', $request, ChangeReceiverResponse::class);
		} catch (BadRequest $e) {
			throw new ChangeReceiverException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ???????????????? ?????????????????????? ???? ?????? ???????????????????????? ????????????.
	 *
	 * ?????????? ?????????????????????? ????????????????, ???????? ?? ?????????????? ?????????????? ???????????? ???????? ???????????? ???????????? ??
	 * ???????????? ?????????????????????? ?????? ???????????????????????????????? (?? ???????? ???????????? ?????????? ???????????????????????? ?????????? ???????? ???????????????? ?????? ????????????????????????????????, ?????????????????????????????? ?????? ???????????? ????????).
	 * ?????????????????? ?? ???????????? ?????????????? ????. ?????????? '???????????? ????????????????????????', ???????????????? ?????????????????? ???????????? 'info.accessLevel'.
	 *
	 * ???????? ???????????????????? ???????????????? ???????????????????? ???? ???????????? ?? ?????????????????? ?????? ????????????????????????, ???? ?????????????? ???????????????????????? ?????????? '?????????????????? ???????????????????? ???? ????????????'.
	 *
	 * ?????? ???????????????? ?????????????????????? ?????????????????? ?????????????????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 *
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????. ?????????? ???????????????????????????? ???????????????? ???????????? ???? ???????????????? ?????????????????? ?????????? ???????? ???????????????? ?????? ??????????????????.
	 * ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param ChangePayerRequest $request
	 *
	 * @return ChangePayerResponse|null
	 *
	 * @throws ChangePayerException
	 *
	 * @see https://dev.dellin.ru/api/order/change-payer/
	 *
	 */
	public function changePayer(ChangePayerRequest $request): ?ChangePayerResponse
	{
		try {
			return $this->client->post('/v3/orders/change_payer.json', $request, ChangePayerResponse::class);
		} catch (BadRequest $e) {
			throw new ChangePayerException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ???????????????? ???????????????????? ???????????????????? ???????????????????????????????? ?? ?????????????????????????????? ???? ????????????
	 * (?????????????? ???????????????????? ?????? ??????????????????????????????, ?????????????????????? '??????????????????' ??????????????????????, ???? ???????? ?????? ????????????????????,
	 * ?? ?????????????? ???????????????????????? ?????????????? ????????????????????, ????. ???????????????? ???????????? '???????????????????? ???????????????? ??????????' ???? ?????????? ???????????????? '?????????????? ??????????').
	 *
	 * ???????????????? ?????????????????? ???????????????????? ???????????????????? ???????????? ???? ??????????????, ?? ?????????????? ???????? ???????????? ?? ?????????????? ???????????? ???????????????? ????????????????????????.
	 * ?????? ???????????????? ?????????????????????? ???????????????? ?????????????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????. ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param ChangeContactsRequest $request
	 *
	 * @return ChangeContactsResponse|null
	 *
	 * @throws ChangeContactsException
	 *
	 * @see https://dev.dellin.ru/api/order/change-contacts/
	 *
	 */
	public function changeContacts(ChangeContactsRequest $request): ?ChangeContactsResponse
	{
		try {
			return $this->client->post('/v3/orders/change_contacts.json', $request, ChangeContactsResponse::class);
		} catch (BadRequest $e) {
			throw new ChangeContactsException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ???????????????? ??????????, ???????? ?? ?????????? ?????????????? ?????????????????????? ?????? ???????????????? ???? ????????????.
	 * ?????? ???????????????? ?????????????????????? ???????????????? ?????????????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????.
	 *
	 * ?????????? ???????????????????????????? ???????????????? ???????????? ???? ???????????????? ?????????????????? ?????????? ???????? ???????????????? ?????? ??????????????????.
	 * ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param ChangePickUpRequest $request
	 *
	 * @return ChangePickUpResponse|null
	 *
	 * @throws ChangePickUpException
	 *
	 * @see https://dev.dellin.ru/api/order/change-pickup/
	 *
	 */
	public function changePickUp(ChangePickUpRequest $request): ?ChangePickUpResponse
	{
		try {
			return $this->client->post('/v3/orders/change_pickup.json', $request, ChangePickUpResponse::class);
		} catch (BadRequest $e) {
			throw new ChangePickUpException($e);
		}
	}


	/**
	 * ???????????? ?????????????????? ???????????????? ???????????????? ???????????????? (?? ????????????, ???????? ???????????????????? ???????? ???????????????? ???????????????? ???? ??????????????????) ?????? ??????????,
	 * ???????? ?? ?????????? ?????????????? ?????????????????????? (???????? ???????? ???????????????? ???????????????? ???? ????????????)
	 * ?? ?????? ?????????????????????????? ?????????????? ???????????? ???????????????????? ??/?????? ?????????????????????? ???? ???????????? ????????????????/?????????????????????????????? ??????????.
	 *
	 * ?????? ???????????????? ?????????????????? ?????????????????? ???????????? ???????????? ?? ??????????????????????, ???????????????????? ?????? ??????????????????????,
	 * ????????????, ?????????????????????????????? ?????????? ?? ???????????? ?????????? ???????????????? ???????????? ?????? ?????????????? ?????????????? ??????????????
	 * ?? ?????????????????????? (?????????????????? ?? ???????????? ?????????????? ????. ?? ???????????????? ?????????????????? ???????????? info.accessLevel ???????????? '???????????? ????????????????????????').
	 *
	 * ?????? ???????????????? ?????????????????????? ???????????????? ?????????????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????. ?????????? ???????????????????????????? ???????????????? ???????????? ???? ???????????????? ?????????????????? ?????????? ???????? ???????????????? ?????? ??????????????????.
	 * ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param ChangeDeliveryRequest $request
	 *
	 * @return ChangeDeliveryResponse|null
	 *
	 * @throws ChangeDeliveryException
	 *
	 * @see https://dev.dellin.ru/api/order/change-delivery/
	 *
	 */
	public function changeDelivery(ChangeDeliveryRequest $request): ?ChangeDeliveryResponse
	{
		try {
			return $this->client->post('/v3/orders/change_delivery.json', $request, ChangeDeliveryResponse::class);
		} catch (BadRequest $e) {
			throw new ChangeDeliveryException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ???????????????? ???????????????? ???? ???????????? ??????????????????????.
	 * ?? ???????????? ???????????? ???????????????? ???? ???????????? ???????????????????????? ???????????????????? ???????????????? ?????????? ?????????? ???? ???????????????? ???? ?????????????????? (????. ?????????? '?????????????????? ?????????????? ????????????').
	 * ???????????? ???????????????? ????/???? ???????????? ???????????????????? ?????????? 17:00 (???? ???????????????? ??????????????) ??????, ?????????????????????????????? ?????? ????????????.
	 *
	 * ?????? ???????????????? ?????????????????????? ???????????? ???????????????? ???? ???????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 *
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????.
	 * ?????????? ???????????????????????????? ???????????????? ???????????? ???? ???????????????? ?????????????????? ?????????? ???????? ???????????????? ?????? ??????????????????.
	 * ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param CancelRequest $request
	 *
	 * @return CancelResponse|null
	 *
	 * @throws CancelPickUpException
	 *
	 * @see https://dev.dellin.ru/api/order/cancel/#_header2
	 *
	 */
	public function cancelPickUp(CancelRequest $request): ?CancelResponse
	{
		try {
			return $this->client->post('/v3/orders/cancel_pickup.json', $request, CancelResponse::class);
		} catch (BadRequest $e) {
			throw new CancelPickUpException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ???????????????? ???????????????? ???? ???????????? ????????????????????.
	 * ?? ???????????? ???????????? ???????????????? ???? ???????????? ???????????????????????? ???????????????????? ???????????????? ?????????? ?????????? ???? ???????????????? ???? ?????????????????? (????. ?????????? '?????????????????? ?????????????? ????????????').
	 * ???????????? ???????????????? ???? ???????????? ???????????????????? ?????????? 17:00 (???? ???????????????? ??????????????) ??????, ?????????????????????????????? ?????? ????????????.
	 *
	 * ?????? ???????????????? ?????????????????????? ???????????? ???????????????? ???? ???????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 *
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????.
	 * ?????????? ???????????????????????????? ???????????????? ???????????? ???? ???????????????? ?????????????????? ?????????? ???????? ???????????????? ?????? ??????????????????.
	 * ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param CancelRequest $request
	 *
	 * @return CancelResponse|null
	 *
	 * @throws CancelDeliveryException
	 *
	 * @see https://dev.dellin.ru/api/order/cancel/#_header2
	 *
	 */
	public function cancelDelivery(CancelRequest $request): ?CancelResponse
	{
		try {
			return $this->client->post('/v3/orders/cancel_delivery.json', $request, CancelResponse::class);
		} catch (BadRequest $e) {
			throw new CancelDeliveryException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ?????????????????????????? ???????????? ??????????.
	 * ?????? ???????????????? ?????????????????? ?????????????????? ???????????? ???????????? ?? ?????????????????????? (?????????????????? ?? ???????????? ?????????????? ????. ?? ???????????????? ?????????????????? ???????????? info.accessLevel ???????????? '???????????? ????????????????????????').
	 * ?????? ???????????????? ?????????????????????? ???????????????? ?????????????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????. ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param SuspendOrderRequest $request
	 *
	 * @return SuspendOrderResponse|null
	 *
	 * @throws SuspendOrderException
	 *
	 * @see https://dev.dellin.ru/api/order/cancel/#_header2
	 *
	 */
	public function suspendOrder(SuspendOrderRequest $request): ?SuspendOrderResponse
	{
		try {
			return $this->client->post('/v3/orders/suspend.json', $request, SuspendOrderResponse::class);
		} catch (BadRequest $e) {
			throw new SuspendOrderException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ?????????????????????? ???????????? ??????????.
	 * ?????? ???????????????? ?????????????????? ?????????????????? ???????????? ???????????? ?? ?????????????????????? (?????????????????? ?? ???????????? ?????????????? ????. ?? ???????????????? ?????????????????? ???????????? info.accessLevel ???????????? '???????????? ????????????????????????').
	 * ?????? ???????????????? ?????????????????????? ???????????????? ?????????????????? ?????????????? ???????????????????????? ?????????? '?????????????????? ?????????????????? ????????????'.
	 * ?????????????????? ???????????????? ?? ???????? ???? ??????????. ?????????????????? ???????????? ???????????? ?????????? ?????? ???????????? ???????????? '?????????????? ?????????????????? ????????????'.
	 *
	 * @param ResumeOrderRequest $request
	 *
	 * @return ResumeOrderResponse|null
	 *
	 * @throws ResumeOrderException
	 *
	 * @see https://dev.dellin.ru/api/order/cancel/#_header2
	 *
	 */
	public function resumeOrder(ResumeOrderRequest $request): ?ResumeOrderResponse
	{
		try {
			return $this->client->post('/v3/orders/resume.json', $request, ResumeOrderResponse::class);
		} catch (BadRequest $e) {
			throw new ResumeOrderException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ?????????????????? ???????????? ?? ???????????? ?????????????????? ??????????????.
	 *
	 * @param AddFavoriteOrderRequest $request
	 *
	 * @return AddFavoriteOrderResponse|null
	 *
	 * @throws AddFavoriteOrderException
	 *
	 * @see https://dev.dellin.ru/api/order/favorites/#_header2
	 *
	 */
	public function addFavoriteOrder(AddFavoriteOrderRequest $request): ?AddFavoriteOrderResponse
	{
		try {
			return $this->client->post('/v2/favorites/add.json', $request, AddFavoriteOrderResponse::class);
		} catch (BadRequest $e) {
			throw new AddFavoriteOrderException($e);
		}
	}

	/**
	 * ???????????? ?????????????????? ?????????????? ???????????? ???? ???????????? ??????????????????.
	 *
	 * @param DeleteFavoriteOrderRequest $request
	 *
	 * @return DeleteFavoriteOrderResponse|null
	 *
	 * @throws DeleteFavoriteOrderException
	 *
	 * @see https://dev.dellin.ru/api/order/favorites/#_header2
	 *
	 */
	public function deleteFavoriteOrder(DeleteFavoriteOrderRequest $request): ?DeleteFavoriteOrderResponse
	{
		try {
			return $this->client->post('/v2/favorites/delete.json', $request, DeleteFavoriteOrderResponse::class);
		} catch (BadRequest $e) {
			throw new DeleteFavoriteOrderException($e);
		}
	}
}
