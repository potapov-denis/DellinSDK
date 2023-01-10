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

namespace Yooogi\DellinSDK;

use ReflectionClass;
use ReflectionException;
use Yooogi\DellinSDK\Core\ArrayOf;

class Instantiator
{
	/** @var string */
	private $class;

	/** @var bool */
	private $array = false;

	/** @var ReflectionClass */
	private $reflector;

	/**
	 * @throws ReflectionException
	 */
	public function __construct($class)
	{
		if ($class instanceof ArrayOf) {
			$this->array = true;
			$this->class = $class->getClass();
		} else {
			$this->class = $class;
		}

		$this->reflector = new ReflectionClass($this->class);
	}

	/**
	 * @param ArrayOf|string $class
	 * @param mixed $data
	 *
	 * @return mixed
	 */
	public static function instantiate($class, $data)
	{
		if (null === $data) {
			return null;
		}

		return (new self($class))->fill($data);
	}

	public function fill($data)
	{
		$metadata = null;

		$build_metadata = static function ($data) use (&$metadata) {
			if (isset($data['metadata'])) {
				$metadata = $data['metadata'];
				unset($data['metadata']);
			}
			if (isset($data['state'])) {
				$metadata['state'] = $data['state'];
			}

			if (isset($data['data']) && is_array($data['data'])) {
				$data = $data['data'];
			}

			/* Фикс для ответа по созданию Мультизаявки */
			if (isset($data['answer']) && is_array($data['answer'])) {
				$data = $data['answer'];
			}

			return $data;
		};


		if (null === $data) {
			return null;
		}

		$data = $build_metadata($data);


		if ($this->array) {
			$objects = [];

			foreach ($data as $key => $item) {
				$item = $build_metadata($item);
				$objects[$key] = $this->build($this->class, $item, $metadata);
			}


			return $objects;
		}


		return $this->build($this->class, $data, $metadata);
	}

	/**
	 * @throws ReflectionException
	 */
	private function build(string $class, array $data, ?array $metadata = null)
	{

		$object = (new ReflectionClass($class))->newInstanceWithoutConstructor();
		$property = $this->reflector->getProperty('data');

		if ($this->reflector->hasProperty('metadata')) {
			$propertyMeta = $this->reflector->getProperty('metadata');
			$propertyMeta->setValue($object, $metadata);
		}


		$property->setValue($object, $data);


		return $object;
	}

	/**
	 * @param string $class
	 * @param object $source
	 * @param array $unset
	 *
	 * @return mixed
	 * @throws ReflectionException
	 *
	 */
	public static function instantiateFrom(string $class, $source, array $unset = [])
	{
		$sourceReflector = (new ReflectionClass($source))->getProperty('data');
		$sourceReflector->setAccessible(true);

		$destination = (new ReflectionClass($class))->newInstanceWithoutConstructor();

		$destinationReflector = (new ReflectionClass($destination))->getProperty('data');
		$destinationReflector->setAccessible(true);

		$data = $sourceReflector->getValue($source);


		foreach ($unset as $item) {
			unset($data[$item]);
		}

		$destinationReflector->setValue($destination, $data);

		return $destination;
	}
}
