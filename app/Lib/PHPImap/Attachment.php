<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-17
 * Time: 14:32
 */

namespace App\Lib\PHPImap;


class Attachment implements AttachmentInterface
{
    private $_obj = null;

    private $_filename = '';
    private $_size = 0;
    private $_partID = '';
    private $_encoding = '';
    private $_mineType = '';

    public function __construct($obj)
    {
        $this->_obj = $obj;
    }

    public function getEncoding(): string
    {
        // TODO: Implement getEncoding() method.
        return $this->_encoding;
    }

    public function setEncoding(string $encoding): AttachmentInterface
    {
        // TODO: Implement setEncoding() method.
        $this->_encoding = $encoding;
        return $this;
    }

    public function getPartID(): string
    {
        // TODO: Implement getPartID() method.
        return $this->_partID;
    }

    public function setPartID(string $partID): AttachmentInterface
    {
        // TODO: Implement setPartID() method.
        $this->_partID = $partID;
        return $this;
    }

    public function getSize(): int
    {
        // TODO: Implement getSize() method.
        return $this->_size;
    }

    public function setSize(int $size): AttachmentInterface
    {
        // TODO: Implement setSize() method.
        $this->_size = $size;
        return $this;
    }

    public function setMineType(string $mineType): AttachmentInterface
    {
        // TODO: Implement setMineType() method.
        $this->_mineType = $mineType;
        return $this;
    }

    public function getMineType(): string
    {
        // TODO: Implement getMineType() method.
        return $this->_mineType;
    }

    public function fetch()
    {

    }
}
