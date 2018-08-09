# zbateson/mail-mime-parser

Testable and PSR-compliant mail mime parser alternative to PHP's imap* functions and Pear libraries for reading messages in _Internet Message Format_ [RFC 822](http://tools.ietf.org/html/rfc822) (and later revisions [RFC 2822](http://tools.ietf.org/html/rfc2822), [RFC 5322](http://tools.ietf.org/html/rfc5322)).

[![Build Status](https://travis-ci.org/zbateson/MailMimeParser.svg?branch=master)](https://travis-ci.org/zbateson/MailMimeParser) [![Code Coverage](https://scrutinizer-ci.com/g/zbateson/MailMimeParser/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/zbateson/MailMimeParser/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zbateson/MailMimeParser/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zbateson/MailMimeParser/?branch=master)
[![Total Downloads](https://poser.pugx.org/zbateson/mail-mime-parser/downloads)](https://packagist.org/packages/zbateson/mail-mime-parser)
[![Latest Stable Version](https://poser.pugx.org/zbateson/mail-mime-parser/version)](https://packagist.org/packages/zbateson/mail-mime-parser)

The goals of this project are to be:

* Well written
* Standards-compliant but forgiving
* Includable via composer
* Tested where possible
* Minimal dependencies

To include it for use in your project, please install via composer:

```
composer require zbateson/mail-mime-parser
```

## Requirements

MailMimeParser requires PHP 5.4 or newer or HHVM.  Tested on PHP 5.4, 5.5, 5.6, 7, 7.1 and 7.2 and HHVM 3.6, 3.12, 3.24 and 'current' on travis.

## Usage

```php
// use an instance of MailMimeParser as a class dependency
$mailParser = new \ZBateson\MailMimeParser\MailMimeParser();

$handle = fopen('file.mime', 'r');
// parse() accepts a string, resource or Psr7 StreamInterface
$message = $mailParser->parse($handle);         // returns a \ZBateson\MailMimeParser\Message
fclose($handle);

// OR: use this procedurally (Message::from also accepts a string,
// resource or Psr7 StreamInterface
$message = \ZBateson\MailMimeParser\Message::from($string);

echo $message->getHeaderValue('from');          // user@example.com
echo $message
    ->getHeader('from')
    ->getPersonName();                          // Person Name
echo $message->getHeaderValue('subject');       // The email's subject

echo $message->getTextContent();                // or getHtmlContent()

$att = $message->getAttachmentPart(0);          // first attachment
echo $att->getHeaderValue('Content-Type');      // e.g. "text/plain"
echo $att->getHeaderParameter(                  // value of "charset" part
    'content-type',
    'charset'
);
echo $att->getContent();                        // get the attached file's contents
$stream = $att->getContentStream();             // the file is decoded automatically
$dest = \GuzzleHttp\Psr7\stream_for(
    fopen('my-file.ext')
);
\GuzzleHttp\Psr7\copy_to_stream(
    $stream, $dest
);
```

## Documentation

* [About](https://mail-mime-parser.org)
* [Usage Guide](https://mail-mime-parser.org/#quick-usage-guide)
* [API Reference](https://mail-mime-parser.org/api/1.0)

## Upgrading to 1.0

* [Upgrade Guide](https://mail-mime-parser.org/upgrade-1.0)

## License

BSD licensed - please see [license agreement](https://github.com/zbateson/MailMimeParser/blob/master/LICENSE).
