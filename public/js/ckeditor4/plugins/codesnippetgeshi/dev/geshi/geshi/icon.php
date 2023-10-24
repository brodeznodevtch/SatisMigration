<?php
/*************************************************************************************
 * icon.php
 * --------
 * Author: Matt Oates (mattoates@gmail.com)
 * Copyright: (c) 2010 Matt Oates (http://mattoates.co.uk)
 * Release Version: 1.0.8.11
 * Date Started: 2010/04/24
 *
 * Icon language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2010/04/24 (0.0.0.2)
 *  -  Validated with Geshi langcheck.php FAILED due to preprocessor keywords looking like symbols
 *  -  Hard wrapped to improve readability
 * 2010/04/20 (0.0.0.1)
 *  -  First Release
 *
 * TODO (updated 2010/04/20)
 * -------------------------
 * - Do the &amp; need replacing with &?
 *
 *************************************************************************************
 *
 *     This file is part of GeSHi.
 *
 *   GeSHi is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   GeSHi is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with GeSHi; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ************************************************************************************/

$language_data = [
    'LANG_NAME' => 'Icon',
    'COMMENT_SINGLE' => [1 => '#'],
    'COMMENT_MULTI' => [],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => ['"', '\''],
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => [
        1 => [
            'break', 'case', 'continue', 'create', 'default', 'do', 'else',
            'end', 'every', 'fail', 'for', 'if', 'import', 'initial',
            'initially', 'invocable', 'link', 'next', 'not', 'of', 'package',
            'procedure', 'record', 'repeat', 'return', 'switch', 'suspend',
            'then', 'to', 'until', 'while',
        ],
        2 => [
            'global', 'local', 'static',
        ],
        3 => [
            'allocated', 'ascii', 'clock', 'collections',
            'column', 'cset', 'current', 'date', 'dateline', 'digits',
            'dump', 'e', 'error', 'errornumber', 'errortext',
            'errorvalue', 'errout', 'eventcode', 'eventsource', 'eventvalue',
            'fail', 'features', 'file', 'host', 'input', 'lcase',
            'letters', 'level', 'line', 'main', 'now', 'null',
            'output', 'phi', 'pi', 'pos', 'progname', 'random',
            'regions', 'source', 'storage', 'subject', 'syserr', 'time',
            'trace', 'ucase', 'version', 'col', 'control', 'interval',
            'ldrag', 'lpress', 'lrelease', 'mdrag', 'meta', 'mpress',
            'mrelease', 'rdrag', 'resize', 'row', 'rpress', 'rrelease',
            'shift', 'window', 'x', 'y',
        ],
        4 => [
            'abs', 'acos', 'any', 'args', 'asin', 'atan', 'bal', 'center', 'char',
            'chmod', 'close', 'cofail', 'collect', 'copy', 'cos', 'cset', 'ctime', 'delay', 'delete',
            'detab', 'display', 'dtor', 'entab', 'errorclear', 'event', 'eventmask', 'EvGet', 'exit',
            'exp', 'fetch', 'fieldnames', 'find', 'flock', 'flush', 'function', 'get', 'getch',
            'getche', 'getenv', 'gettimeofday', 'globalnames', 'gtime', 'iand', 'icom', 'image',
            'insert', 'integer', 'ior', 'ishift', 'ixor', 'key', 'left', 'list', 'load', 'loadfunc',
            'localnames', 'log', 'many', 'map', 'match', 'member', 'mkdir', 'move', 'name', 'numeric',
            'open', 'opmask', 'ord', 'paramnames', 'parent', 'pipe', 'pop', 'pos', 'proc', 'pull',
            'push', 'put', 'read', 'reads', 'real', 'receive', 'remove', 'rename', 'repl', 'reverse',
            'right', 'rmdir', 'rtod', 'runerr', 'seek', 'select', 'send', 'seq', 'serial', 'set',
            'setenv', 'sort', 'sortf', 'sql', 'sqrt', 'stat', 'stop', 'string', 'system', 'tab',
            'table', 'tan', 'trap', 'trim', 'truncate', 'type', 'upto', 'utime', 'variable', 'where',
            'write', 'writes',
        ],
        5 => [
            'Active', 'Alert', 'Bg', 'Clip', 'Clone', 'Color', 'ColorValue',
            'CopyArea', 'Couple', 'DrawArc', 'DrawCircle', 'DrawCurve', 'DrawCylinder', 'DrawDisk',
            'DrawImage', 'DrawLine', 'DrawPoint', 'DrawPolygon', 'DrawRectangle', 'DrawSegment',
            'DrawSphere', 'DrawString', 'DrawTorus', 'EraseArea', 'Event', 'Fg', 'FillArc',
            'FillCircle', 'FillPolygon', 'FillRectangle', 'Font', 'FreeColor', 'GotoRC', 'GotoXY',
            'IdentifyMatrix', 'Lower', 'MatrixMode', 'NewColor', 'PaletteChars', 'PaletteColor',
            'PaletteKey', 'Pattern', 'Pending', 'Pixel', 'PopMatrix', 'PushMatrix', 'PushRotate',
            'PushScale', 'PushTranslate', 'QueryPointer', 'Raise', 'ReadImage', 'Refresh', 'Rotate',
            'Scale', 'Texcoord', 'TextWidth', 'Texture', 'Translate', 'Uncouple', 'WAttrib',
            'WDefault', 'WFlush', 'WindowContents', 'WriteImage', 'WSync',
        ],
        6 => [
            'define', 'include', 'ifdef', 'ifndef', 'else', 'endif', 'error',
            'line', 'undef',
        ],
        7 => [
            '_V9', '_AMIGA', '_ACORN', '_CMS', '_MACINTOSH', '_MSDOS_386',
            '_MS_WINDOWS_NT', '_MSDOS', '_MVS', '_OS2', '_POR', 'T', '_UNIX', '_POSIX', '_DBM',
            '_VMS', '_ASCII', '_EBCDIC', '_CO_EXPRESSIONS', '_CONSOLE_WINDOW', '_DYNAMIC_LOADING',
            '_EVENT_MONITOR', '_EXTERNAL_FUNCTIONS', '_KEYBOARD_FUNCTIONS', '_LARGE_INTEGERS',
            '_MULTITASKING', '_PIPES', '_RECORD_IO', '_SYSTEM_FUNCTION', '_MESSAGING', '_GRAPHICS',
            '_X_WINDOW_SYSTEM', '_MS_WINDOWS', '_WIN32', '_PRESENTATION_MGR', '_ARM_FUNCTIONS',
            '_DOS_FUNCTIONS',
        ],
        8 => [
            'line',
        ],
    ],
    'SYMBOLS' => [
        1 => [
            '(', ')', '{', '}', '[', ']', '+', '-', '*', '/', '\\', '%', '=', '<', '>', '!', '^',
            '&', '|', '?', ':', ';', ',', '.', '~', '@',
        ],
        2 => [
            '$(', '$)', '$<', '$>', '$',
        ],
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        5 => true,
        6 => true,
        7 => true,
        8 => true,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #b1b100;',
            2 => 'color: #b1b100;',
            3 => 'color: #b1b100;',
            4 => 'color: #b1b100;',
            5 => 'color: #b1b100;',
            6 => 'color: #b1b100;',
            7 => 'color: #b1b100;',
            8 => 'color: #b1b100;',
        ],
        'COMMENTS' => [
            1 => 'color: #666666; font-style: italic;',
            'MULTI' => 'color: #666666; font-style: italic;',
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #000099; font-weight: bold;',
        ],
        'BRACKETS' => [
            0 => 'color: #009900;',
        ],
        'STRINGS' => [
            0 => 'color: #0000ff;',
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;',
        ],
        'METHODS' => [
            0 => 'color: #004000;',
        ],
        'SYMBOLS' => [
            1 => 'color: #339933;',
            2 => 'color: #b1b100;',
        ],
        'REGEXPS' => [],
        'SCRIPT' => [],
    ],
    'URLS' => [
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
        8 => '',
    ],
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => [1 => '.'],
    'REGEXPS' => [],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => [],
    'HIGHLIGHT_STRICT_BLOCK' => [],
    'PARSER_CONTROL' => [
        'KEYWORDS' => [
            3 => [
                'DISALLOWED_BEFORE' => '(?<=&amp;)',
            ],
            4 => [
                'DISALLOWED_BEFORE' => "(?<![a-zA-Z0-9_\"\'])",
                'DISALLOWED_AFTER' => "(?![a-zA-Z0-9_\"\'])",
            ],
            6 => [
                'DISALLOWED_BEFORE' => '(?<=\$)',
            ],
            8 => [
                'DISALLOWED_BEFORE' => '(?<=#)',
            ],
        ],
    ],
];
