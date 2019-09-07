<?php

declare(strict_types=1);

/*

Copyright (c) 2017-2019 Mika Tuupola

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

/**
 * @see       https://github.com/tuupola/http-factory
 * @license   http://www.opensource.org/licenses/mit-license.php
 */

namespace Tuupola\Http\Factory;

use GuzzleHttp\Psr7\Stream as GuzzleStream;
use Nyholm\Psr7\Stream as NyholmStream;
use Slim\Http\Stream as SlimStream;
use Slim\Psr7\Factory\StreamFactory as SlimPsr7StreamFactory;
use Zend\Diactoros\Stream as DiactorosStream;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class StreamFactory implements StreamFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createStream(string $content = ""): StreamInterface
    {
        if (class_exists(SlimPsr7StreamFactory::class)) {
            return (new SlimPsr7StreamFactory)->createStream($content);
        }

        $resource = fopen("php://temp", "r+");
        $stream = $this->createStreamFromResource($resource);
        $stream->write($content);

        return $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function createStreamFromFile(string $filename, string $mode = "r"): StreamInterface
    {
        if (class_exists(SlimPsr7StreamFactory::class)) {
            return (new SlimPsr7StreamFactory)->createStreamFromFile($filename, $mode);
        }

        $resource = fopen($filename, $mode);
        return $this->createStreamFromResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        if (class_exists(DiactorosStream::class)) {
            return new DiactorosStream($resource);
        }

        if (class_exists(NyholmStream::class)) {
            return NyholmStream::create($resource);
        }

        if (class_exists(SlimPsr7StreamFactory::class)) {
            return (new SlimPsr7StreamFactory)->createStreamFromResource($resource);
        }

        if (class_exists(SlimStream::class)) {
            return new SlimStream($resource);
        }

        if (class_exists(GuzzleStream::class)) {
            return new GuzzleStream($resource);
        }

        throw new \RuntimeException("No PSR-7 implementation available");
    }
}
