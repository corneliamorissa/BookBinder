<?php declare(strict_types=1);

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Avatar;

class AvatarTest extends TestCase
{

    public function testGetAttributes(): void{
        $avatar = new Avatar();

        $this -> assertEquals(null,$avatar -> getImage());
        $this -> assertEquals(null,$avatar -> getId());

        $avatar -> setId(1);
        $avatar -> setImage("blob data");

        $this->assertEquals(1,$avatar -> getId());
        $this->assertSame("blob data", $avatar -> getImage());

        //no test yet for the getUsersMethod

    }

}