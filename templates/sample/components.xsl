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
<?xml version='1.0' encoding='UTF-8'?>

<xsl:transform version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:tpl='http://www.squille.com/2018/XSL/Template'>

    <xsl:output method="xml" indent="yes"/>
    <xsl:template match="node()|@*">
        <xsl:copy>
            <xsl:apply-templates select="node()|@*"/>
        </xsl:copy>
    </xsl:template>

    <!-- Content components. -->
    <xsl:template match="content[@component='as-is']" tpl:content="as-is">
        <xsl:copy-of select='text/node()'/>
    </xsl:template>
    <!-- Content components. -->

    <!-- Category components. -->
    <xsl:template match="category[@component='categoria-example']" tpl:category="categoria-example">
        <section class='category'>
            <h2><a name='{@description}'><xsl:comment/></a><xsl:value-of select='@description'/></h2>
            <div class='itens'>
                <xsl:for-each select="contents/content">
                    <h3>Subtitle</h3>
                </xsl:for-each>
            </div>
        </section>
    </xsl:template>
    <!-- Category components. -->

    <!-- Menu components. -->
    <xsl:template match="menu[@component='horizontal-dotted']" tpl:menu="horizontal-dotted">
        <ul class='dot-separated'>
            <xsl:for-each select='link'>
                <li><a href='{@href}'><xsl:value-of select='text()'/></a></li>
            </xsl:for-each>
        </ul>
    </xsl:template>
    <!-- Menu components. -->
</xsl:transform>
