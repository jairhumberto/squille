<?xml version='1.0' encoding='UTF-8'?>
<!--
 - Squille (https://github.com/jairhumberto/Squille)
 -
 - MIT License
 -
 - Copyright (c) 2017 Jair Humberto
 -
 - Permission is hereby granted, free of charge, to any person obtaining a copy
 - of this software and associated documentation files (the "Software"), to deal
 - in the Software without restriction, including without limitation the rights
 - to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 - copies of the Software, and to permit persons to whom the Software is
 - furnished to do so, subject to the following conditions:
 -
 - The above copyright notice and this permission notice shall be included in all
 - copies or substantial portions of the Software.
 -
 - THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 - IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 - FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 - AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 - LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 - OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 - SOFTWARE.
 -->

<xsl:transform  version='1.0'
                xmlns:xsl='http://www.w3.org/1999/XSL/Transform'
                xmlns:tpl='http://www.squille.com/2018/XSL/Template'>
    <xsl:template match='/'>
        <xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
        <html lang='pt'>
            <head>
                <meta charset='utf-8'/>
                <title>Example Site</title>

                <!-- Adding CSS through CDN (recommended) -->
                <link rel='stylesheet' href='http://your.cdn.com/css/style.css' type='text/css'/>
            </head>
            <body>
                <div class='page'>
                    <header>
                        <div tpl:section='header'>
                            <a href='/'><h1 class='logo'>Example</h1></a>
                            <ul class='top dash-separated'>
                                <li>55 77 9 4300 0000</li>
                                <li><a href='#'>Register</a></li>
                            </ul>
                            <xsl:copy-of select='//*[@section="header"]'/>
                        </div>
                    </header>

                    <div class='content' tpl:section='content'>
                        <!-- Your content here. -->
                        <xsl:copy-of select='//*[@section="content"]'/>
                    </div>

                    <footer>
                        <p>© Example Site 2017</p>
                        <p>Proudly powered by Squille</p>
                    </footer>
                </div>
            </body>

            <!-- Adding script example. -->
            <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"><xsl:comment/></script>

            <!-- Main script through CDN (recommended). -->
            <script src='http://your.cdn.com/scripts/script.js'><xsl:comment/></script>
        </html>
    </xsl:template>
</xsl:transform>
