    <script type="text/ng-template" id="about.html">

        <div class="modal-header">
            <h3 class="modal-title">About</h3>
        </div>
        <CENTER>
        <IMG SRC="./css/logo.png" width="40%" height="40%">
        <BR>cIFrex is a small script written in PHP, which supports search for mistakes in the analysis of the source code. Using the database of filters based on regular expressions, you can quickly locating the code, in which the probability of failure is high. You will just need to have the source code on a computer with the access to cIFrex in order to be able to fully benefit from the possibilities of the new methodology.
<P class="txt" id="howtouse">&nbsp;&nbsp;<h1><b>How to use?</b></h1>
<P class="txt"><B>cIFrex filters</B> are based on regular expressions, describing given kind of mistake together with the <I>CWE identifiers</I>. This enables you to reach a lexical definition at <A HREF="http://cwe.mitre.org" TITLE="CWE">http://cwe.mitre.org</A> fast.<P class="txt"><CENTER><B>Each filter is based on maximum of nine patterns.</B></CENTER>
<P class="txt"><CENTER>Regular expressions can be divided in three groups:</CENTER>
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/vtf.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/vtf.jpg" alt="cIFrex" width="600" height="130"></A></CENTER>

<P class="txt">- <B>(V) Value:</B> Regular expression enabling retrieval of the sequences of signs and the attribution of retrieved values to the variable &lt;v1&gt;, &lt;v2&gt; lub &lt;v3&gt; for example the name of array:<center><P><FONT COLOR="#698B22"><B>char name[128] =&gt; char.* (?&lt;v1&gt;\w+)\[(\d+)\]</B></FONT></center>
<P class="txt"><CENTER>There is a possibility of using variables &lt;v1&gt;, &lt;v2&gt; and &lt;v3&gt; to search for sequences that are interesting to us. <BR>It allows us to use found values in the patterns of type <B>T (Truth)</B> and <B>F (False)</B>.</CENTER>
<P class="txt">- <B>(T) Truth:</B> Regular expression, which must be present in the code. for example:<center><P><FONT COLOR="#698B22"><B>strcpy\(&lt;v1&gt;\,</B></FONT></center>
<P class="txt">- <B>(F) False:</B> Regular expression, which cannot be present in the code. for example:<center><P><FONT COLOR="#698B22"><B>if.*(?:<v1>.\=\=.NULL|NULL.\=\=.<v1>)</B></FONT></center>

<P class="txt">Each expression fulfils given roles. The expressions of type <B>(V)</B> are used mainly to assign the variable names while the expression of type <B>(T)</B> and <B>(F)</B> are mainly used to precise their usage. To put it simply, patterns of type V are used to catch names of variables, used in the unsuitable manner, for example all arrays (<B>&lt;V1&gt;</B>) of type CHAR used in the function strcpy()(<B>&lt;T1&gt;</B>) without controlling the length through strlen()(<B>&lt;F1&gt;</B>). 
<P class="txt"><CENTER>We will also need to specify directory what we wish to analyse.<BR>It is possible to change default directory by setting <A HREF="#install">$default_directory</A> in the code of <B>cIFrex</B>.<P>Which means the localization of the analyzed source code.</CENTER>
<P><CENTER><IMG SRC="http://cxsecurity.com/images/cifrex/directory.jpg" alt="cIFrex directory"></CENTER>
<P class="txt"><CENTER>To speed up the search process, we mark language which are interesting to us. This allows the script to omit the unneeded files in the filtration process.</CENTER>
<P><CENTER><IMG SRC="http://cxsecurity.com/images/cifrex/langs.jpg" alt="cIFrex langs"></CENTER>
<P class="txt"><CENTER>We can start scanning the files by pressing the button</CENTER>
<P><CENTER><IMG SRC="http://cxsecurity.com/images/cifrex/find.jpg" alt="cIFrex find"></CENTER>

<P class="txt">By using three types regular expressions, we can create a filter which will be checked in all indicated files. If all expressions will be fulfilled, file will be shown in the search results. This does not mean, that it is susceptible to the given mistake. The efficiency of the method can oscillate on the level several percent, depending on the filter exactness. More details in the regular expressions gives us the larger probability of finding the error. 
<P class="txt">Let us analyse thoroughly after-mentioned example. It try find name and size of CHAR Table through the pattern: <B>V1</B><P class="txt"><FONT COLOR="#698B22"><CENTER><B>char.* (?&lt;v1&gt;\w+)\[(?&lt;v2&gt;.*)\]</CENTER></B></FONT>
<P class="txt">Thanks to the application of variables &lt;v1&gt; and &lt;v2&gt;, we can dynamically find the name of table and its size. This can help us in the creation of succeeding regular expressions of type <B>T</B> and <B>F</B>. In this case, the expression of type <B>T1</B> is:<P class="txt"><FONT COLOR="#698B22"><CENTER><B>(.*strcpy\(&lt;v1&gt;\,.*)</CENTER></B></FONT>
<P class="txt">If in the given file will be found line with use of strcpy() function and the name  &lt;v1&gt; condition will be fulfilled. In contrast to the conditions of type <B>F</B>, which are fulfilled in the situation when a given expression does not appear in the code. For example use of array name &lt;v1&gt; and the string NULL &lt;v1&gt;.*NULL in one line.<P class="txt">&nbsp;
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/phpchar1.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/phpchar1.jpg" alt="cIFrex example 1" width="500" height="350"></A></CENTER>
<P class="txt">&nbsp;
<P class="txt"><CENTER>If in the given file all the logic of the expressions will be fulfilled cIFrex will inform us about this in this way:</CENTER>
<P class="txt">&nbsp;
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/phpchar2.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/phpchar2.jpg" alt="cIFrex example 2" width="500" height="350"></A></CENTER>
<P class="txt">&nbsp;
<P class="txt">It can be seen in the after-mentioned example, that cIFrex helped us to find the use of function strcpy () in the risky manner. Copying the indicator f2 to the board f2copy [1000] without controlling its length, can show in the large degree the appearance of mistake. cIFrex does not state that the error has occurred, but only helps in finding the risky programmers behaviours.<P class="txt">&nbsp;
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/phpchar3.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/phpchar3.jpg" alt="cIFrex example 3" width="500" height="350"></A></CENTER>
<P class="txt">&nbsp;
<P class="txt">Another example of cIFrex use is the search of dangerous use of function malloc (), realloc () or calloc (). As we know, each of these functions when lacking the possibility of the allocation of a given data block, returns NULL. If we do not control returned values we can cause NULL pointer dereference error to occur.<P class="txt">&nbsp;
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/phpnull1.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/phpnull1.jpg" alt="cIFrex example 1" width="500" height="350"></A></CENTER>
<P class="txt">&nbsp;
<P class="txt"><CENTER>Search results</CENTER>
<P class="txt">&nbsp;
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/phpnull2.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/phpnull2.jpg" alt="cIFrex example 2" width="500" height="350"></A></CENTER>
<P class="txt">&nbsp;
<P class="txt"><CENTER>Example of bad usage of the *alloc () functions</CENTER>
<P class="txt">&nbsp;
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/phpnull3.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/phpnull3.jpg" alt="cIFrex example 3" width="500" height="350"></A></CENTER>
<P class="txt">&nbsp;
<P class="txt"><CENTER>There are many other ways to use cIFrex. The more detailed is the regular expression the more accurate are the search results.</CENTER>
<P class="txt">&nbsp;
<P><CENTER><A HREF="http://cxsecurity.com/images/cifrex/phpbuff.jpg" TITLE="cIFrex"><IMG SRC="http://cxsecurity.com/images/cifrex/phpbuff.jpg" alt="cIFrex example" width="500" height="350"></A></CENTER>
<P class="txt">&nbsp;<BR><B>Remember that cIFrex:</B>
<P class="txt">- helps to search for the mistakes<BR>- the search results does not guarantee the appearance of the susceptibilities<BR>- the more exact the regular expression, the larger probability of the appearance of the susceptibilities

        	<B>References</B>
           <BR>
           <A HREF="http://cifrex.org/">Web Site</A>
        </CENTER>
        </div>

        <div class="modal-footer">
			<button class="btn btn-primary" ng-click="ok()">Close</button>
        </div>
        
    </script>
