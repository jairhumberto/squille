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

    <!-- componentes gerais -->
    <xsl:template match="content[@component='banner']" tpl:content="banner">
        <div data-src='{text//img/@src}'><xsl:comment/></div>
    </xsl:template>

    <xsl:template match="content[@component='raw']" tpl:content="raw">
        <xsl:copy-of select='text/node()'/>
    </xsl:template>
    <!-- componentes gerais -->

    <!-- componentes de categorias -->
    <xsl:template match="category[@component='categoria-de-produto']" tpl:category="categoria-de-produto">
        <section class='category'>
            <h2><a name='{@description}'><xsl:comment/></a><xsl:value-of select='@description'/></h2>
            <div class='itens'>
                <xsl:for-each select="contents/content">
                    <div class='item'>
                        <a href='{text//img[1]/@src}' class='fancybox'>
                            <div class='image'>
                                <img src='{text//img[1]/@src}' alt='{text/h1}'/>
                            </div>
                            <p class='info'><xsl:value-of select='text/h1'/></p>
                        </a>
                    </div>
                </xsl:for-each>
            </div>
        </section>
    </xsl:template>
    <!-- componentes de categorias -->

    <!-- menus -->
    <xsl:template match="menu[@component='horizontal-dotted']" tpl:menu="horizontal-dotted">
        <ul class='dot-separated'>
            <xsl:for-each select='link'>
                <li><a href='{@href}' class='scroller'><xsl:value-of select='text()'/></a></li>
            </xsl:for-each>
        </ul>
    </xsl:template>
    <!-- menus -->
</xsl:transform>