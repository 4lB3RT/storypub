<?php

namespace Fast\Parser;

class StdTest extends \PhpUnit_Framework_TestCase {
    /** @dataProvider provideTestParse */
    public function testParse($String, $expectedDatas) {
        $parser = new Std();
        $Datas = $parser->parse($String);
        $this->assertSame($expectedDatas, $Datas);
    }

    /** @dataProvider provideTestParseError */
    public function testParseError($String, $expectedExceptionMessage) {
        $parser = new Std();
        $this->setExpectedException('Fast\\BadException', $expectedExceptionMessage);
        $parser->parse($String);
    }

    public function provideTestParse() {
        return [
            [
                '/test',
                [
                    ['/test'],
                ]
            ],
            [
                '/test/{param}',
                [
                    ['/test/', ['param', '[^/]+']],
                ]
            ],
            [
                '/te{ param }st',
                [
                    ['/te', ['param', '[^/]+'], 'st']
                ]
            ],
            [
                '/test/{param1}/test2/{param2}',
                [
                    ['/test/', ['param1', '[^/]+'], '/test2/', ['param2', '[^/]+']]
                ]
            ],
            [
                '/test/{param:\d+}',
                [
                    ['/test/', ['param', '\d+']]
                ]
            ],
            [
                '/test/{ param : \d{1,9} }',
                [
                    ['/test/', ['param', '\d{1,9}']]
                ]
            ],
            [
                '/test[opt]',
                [
                    ['/test'],
                    ['/testopt'],
                ]
            ],
            [
                '/test[/{param}]',
                [
                    ['/test'],
                    ['/test/', ['param', '[^/]+']],
                ]
            ],
            [
                '/{param}[opt]',
                [
                    ['/', ['param', '[^/]+']],
                    ['/', ['param', '[^/]+'], 'opt']
                ]
            ],
            [
                '/test[/{name}[/{id:[0-9]+}]]',
                [
                    ['/test'],
                    ['/test/', ['name', '[^/]+']],
                    ['/test/', ['name', '[^/]+'], '/', ['id', '[0-9]+']],
                ]
            ],
            [
                '',
                [
                    [''],
                ]
            ],
            [
                '[test]',
                [
                    [''],
                    ['test'],
                ]
            ],
            [
                '/{foo-bar}',
                [
                    ['/', ['foo-bar', '[^/]+']]
                ]
            ],
            [
                '/{_foo:.*}',
                [
                    ['/', ['_foo', '.*']]
                ]
            ],
        ];
    }

    public function provideTestParseError() {
        return [
            [
                '/test[opt',
                "Number of opening '[' and closing ']' does not match"
            ],
            [
                '/test[opt[opt2]',
                "Number of opening '[' and closing ']' does not match"
            ],
            [
                '/testopt]',
                "Number of opening '[' and closing ']' does not match"
            ],
            [
                '/test[]',
                "Empty optional part"
            ],
            [
                '/test[[opt]]',
                "Empty optional part"
            ],
            [
                '[[test]]',
                "Empty optional part"
            ],
            [
                '/test[/opt]/required',
                "Optional segments can only occur at the end of a "
            ],
        ];
    }
}
