<?php
namespace ZBateson\MailMimeParser\Header\Part;

use PHPUnit\Framework\TestCase;

/**
 * Description of CommentTest
 *
 * @group HeaderParts
 * @group CommentPart
 * @covers ZBateson\MailMimeParser\Header\Part\CommentPart
 * @covers ZBateson\MailMimeParser\Header\Part\HeaderPart
 * @author Zaahid Bateson
 */
class CommentPartTest extends TestCase
{
    private $charsetConverter;

    public function setUp()
    {
        $this->charsetConverter = $this->getMockBuilder('ZBateson\StreamDecorators\Util\CharsetConverter')
			->disableOriginalConstructor()
			->getMock();
    }

    public function testBasicComment()
    {
        $comment = 'Some silly comment made about my moustache';
        $part = new CommentPart($this->charsetConverter, $comment);
        $this->assertEquals('', $part->getValue());
        $this->assertEquals($comment, $part->getComment());
    }

    public function testMimeEncoding()
    {
        $this->charsetConverter->expects($this->once())
            ->method('convert')
            ->with('Kilgore Trout', 'US-ASCII', 'UTF-8')
            ->willReturn('Kilgore Trout');
        $part = new CommentPart($this->charsetConverter, '=?US-ASCII?Q?Kilgore_Trout?=');
        $this->assertEquals('', $part->getValue());
        $this->assertEquals('Kilgore Trout', $part->getComment());
    }
}
