<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfrRest\Serializer;

use Zend\ServiceManager\AbstractPluginManager;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use ZfrRest\Serializer\Exception\RuntimeException;

/**
 * DecoderPluginManager
 *
 * @license MIT
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 */
class DecoderPluginManager extends AbstractPluginManager
{
    /**
     * @var array
     */
    protected $invokableClasses = array(
        'application/xml' => 'Symfony\Component\Serializer\Encoder\XmlEncoder'
    );

    /**
     * Factories are used for JsonDecoder because, by default, Symfony\Serializer component return
     * data as stdClass, while we prefer the data to be returned as plain associative arrays
     *
     * @var array
     */
    protected $factories = array(
        'application/json'       => 'ZfrRest\Factory\JsonDecoderFactory',
        'application/javascript' => 'ZfrRest\Factory\JsonDecoderFactory',
    );

    /**
     * {@inheritDoc}
     */
    public function validatePlugin($plugin)
    {
        if (! $plugin instanceof DecoderInterface) {
            throw RuntimeException::invalidDecoderPlugin($plugin);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function canonicalizeName($name)
    {
        return $name;
    }
}
