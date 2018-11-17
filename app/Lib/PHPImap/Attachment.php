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
    private $_message = null;

    private $_filename = '';
    private $_size = 0;
    private $_partID = '';
    private $_encoding = '';
    private $_mineType = '';
    private $_data = '';

    public function __construct(Message $message)
    {
        $this->_message = $message;
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

    public function setFilename(string $filename): AttachmentInterface
    {
        // TODO: Implement setFilename() method.
        $this->_filename = $filename;
        return $this;
    }

    public function getFilename(): string
    {
        // TODO: Implement getFilename() method.
        return $this->_filename;
    }

    public function getData(): string
    {
        // TODO: Implement getData() method.
        return $this->_data;
    }

    public function setData(string $data): AttachmentInterface
    {
        // TODO: Implement setData() method.
        $this->_data = $data;
        return $this;
    }

    public function fetch() : self
    {
        $body = imap_fetchbody($this->_message->getConnection(),
            $this->_message->getMessageNo(), $this->_partID, FT_PEEK);

        switch ($this->getEncoding()){
            case 'quoted-printable':
                $body = quoted_printable_decode($body);
                break;
            case ENCBASE64:
            case 'base64':
                $body = base64_decode($body);
                break;
        }

        $this->setData($body);

        return $this;
    }
}
