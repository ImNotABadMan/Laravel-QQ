<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-17
 * Time: 14:34
 */

namespace App\Lib\PHPImap;


interface AttachmentInterface
{
    public function setSize(int $size) : AttachmentInterface ;

    public function getSize() : int ;

    public function setEncoding(string $encoding) : AttachmentInterface ;

    public function getEncoding() : string ;

    public function setFilename(string $filename) : AttachmentInterface ;

    public function setPartID(string $partID) : AttachmentInterface ;

    public function getPartID() : string ;

    public function setMineType(string $mineType) : AttachmentInterface ;

    public function getMineType() : string ;
}
