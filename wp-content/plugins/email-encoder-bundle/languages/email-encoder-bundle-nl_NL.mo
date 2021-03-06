��    ]           �      �     �  L  �  I  F	  �   �
  �  $  �  �  �  �  �      �   �     �     �  #   �     �     �     �     �  O        b  T   s     �     �     �          +     D  #   [       R   �     �     �     �          %     -     >     L     P     ]     q     �     �  �   �  	   E     O  L   X     �     �  n   �  Z   /  �   �  �   .  $   �  -   #     Q     _  
   x  5   �     �     �  `   �     N     j     v  B   �  )   �      �        8   .   2   g      �      �   +   �   &   �       !     ,!     5!  
   E!     P!  \   b!     �!  8   �!     "  O   %"     u"     }"  A   �"     �"     �"  E   #  5   G#  Q   }#  �   �#  �  _$     -&  Q  <&  X  �'  �   �(  m  u)  )  �,  �  0  �   �4  �   �5     N6     Z6  *   c6     �6     �6     �6     �6  S   �6     37  a   F7  !   �7     �7     �7     �7     8     $8  #   ;8     _8  R   k8     �8     �8     �8     �8  	   9     9     !9     29     69     C9     [9     z9     �9  �   �9  	   1:     ;:  M   D:     �:     �:  z   �:  W   0;  �   �;  �   ?<  +   =  8   C=     |=     �=     �=  ?   �=     �=     >  e   %>     �>  
   �>     �>  8   �>  *   �>  "   )?     L?  ,   i?  9   �?     �?     �?  -   �?  (   '@  &   P@     w@     �@  
   �@     �@  q   �@     .A  7   FA     ~A  R   �A     �A     �A  G   B  &   JB     qB  K   �B  S   �B  X   /C  �   �C            5   9          *      :       -   0       
   .   L              	           ?                )      ;   K   C                     U         M   F   $          E   @   X   ,       N   Y       "   D             /       <      2   W       O   [   '              #                 T          R   +   J   P       I   ]   \   =      !   >   6         V   Q           B   A   8       &                 7               S       4   G      Z   %   3      1              (   H     - Recommended! <h3><img src="%s" width="16" height="16" /> %s - version %s</h3><p>The plugin works out-of-the-box. All mailto links in your posts, pages, comments and (text) widgets will be encoded (by default). <br/>If you also want to encode plain email address as well, you have to check the option.</p><img src="%s" width="600" height="273" /> <h3>Action Hooks</h3><h4>eeb_ready</h4><p>Add extra code on initializing this plugin, like extra filters for encoding.</p><pre><code><&#63;php
add_action('eeb_ready', 'extra_encode_filters');

function extra_encode_filters($eeb_object) {
    add_filter('some_filter', array($eeb_object, 'callback_filter'));
}
&#63;></code></pre> <h3>FAQ</h3><p>Please check the <a href="http://wordpress.org/extend/plugins/email-encoder-bundle/faq/" target="_blank">FAQ on the Plugin site</a>. <h3>Filter Hooks</h3><h4>eeb_mailto_regexp</h4><p>You can change the regular expression used for searching mailto links.</p><pre><code><&#63;php
add_filter('eeb_mailto_regexp', 'change_mailto_regexp');

function change_mailto_regexp($regexp) {
    return '-your regular expression-';
}
&#63;></code></pre><h4>eeb_email_regexp</h4><p>You can change the regular expression used for searching mailto links.</p><pre><code><&#63;php
add_filter('eeb_email_regexp', 'change_email_regexp');

function change_email_regexp($regexp) {
    return '-your regular expression-';
}
&#63;></code></pre><h4>eeb_form_content</h4><p>Filter for changing the form layout.</p><pre><code><&#63;php
add_filter('eeb_form_content', 'eeb_form_content', 10, 4);

function eeb_form_content($content, $labels, $show_powered_by, $methods) {
    // add a &lt;div&gt;-wrapper
    return '&lt;div class="form-wrapper"&gt;' . $content . '&lt;/div&gt;';
}
&#63;></code></pre> <h3>Shortcodes</h3><p>You can use these shortcodes within your post or page.</p><h4>eeb_email</h4><p>Create an encoded mailto link:</p><p><code>[eeb_email email="..." display="..."]</code></p><ul><li>"display" is optional or the email wil be shown as display (also protected)</li><li>"extra_attrs" is optional, example: <code>extra_attrs="target='_blank'"</code></li><li>"method" is optional, else the method option will be used.</li></ul><h4>eeb_content</h4><p>Encode some text:</p><p><code>[eeb_content method="..."]...[/eeb_content]</code></p><ul><li>"method" is optional, else the method option will be used.</li></ul><h4>eeb_form</h4><p>Create an encoder form:</p><p><code>[eeb_form]</code></p> <h3>Template Functions</h3><h4>eeb_email()</h4><p>Create an encoded mailto link:</p><pre><code><&#63;php
if (function_exists('eeb_email')) {
    echo eeb_email('info@somedomain.com');
}
&#63;></code></pre><p>You can pass a few extra optional params (in this order): <code>display</code>, <code>extra_attrs</code>, <code>method</code></p><h4>eeb_content()</h4><p>Encode some text:</p><pre><code><&#63;php
if (function_exists('eeb_content')) {
    echo eeb_content('Encode this text');
}
&#63;></code></pre><p>You can pas an extra optional param: <code>method</code></p><h4>eeb_email_filter()</h4><p>Filter given content and encode all email addresses or mailto links:</p><pre><code><&#63;php
if (function_exists('eeb_email_filter')) {
    echo eeb_email_filter('Some content with email like info@somedomein.com or a mailto link');
}
&#63;></code></pre><p>You can pass a few extra optional params (in this order): <code>enc_tags</code>, <code>enc_mailtos</code>, <code>enc_plain_emails</code>, <code>enc_input_fields</code></p><h4>eeb_form()</h4><p>Create an encoder form:</p><pre><code><&#63;php
if (function_exists('eeb_form')) {
    echo eeb_form();
}
&#63;></code></pre> <h4>About the author</h4><ul><li><a href="http://www.freelancephp.net/" target="_blank">FreelancePHP.net</a></li><li><a href="http://www.freelancephp.net/contact/" target="_blank">Contact</a></li></ul> <p>Warning - The plugin <strong>%s</strong> requires PHP 5.2.4+ and WP 3.6+.  Please upgrade your PHP and/or WordPress.<br/>Disable the plugin to remove this message.</p> Action Hook Activate Add class to protected mailto links Additional Settings Admin Settings All comments All posts and pages All protected mailto links will get these class(es). Optional, else keep blank. All text widgets All widgets (uses the <code>widget_content</code> filter of the Widget Logic plugin) Also use shortcodes in widgets. Apply on... Check "succesfully encoded" Choose admin menu position Choose protection method Choose what to protect Create Protected Mail Link &gt;&gt; Display Text: Do <strong>not</strong> apply protection on posts or pages with the folllowing ID: Documentation Email Address: Email Encoder Bundle Email Encoder Form Encoded Encoding Method: Exclude posts FAQ Filter Hooks For encoded emails: For other encoded content: Get this plugin Html Encode If you like you can also create you own secure mailto links manually with this form. Just copy the generated code and put it on your post, page or template. JS Escape JS Rot13 Keep supporting the old names for action, shortcodes and template functions. Mailto Link: Main Settings Manage external links on your site: open in new window/tab, set icon, add "external", add "nofollow" and more. Manage mailto links on your site and protect emails from spambots, set mail icon and more. Not recommended, equal to <a href="http://codex.wordpress.org/Function_Reference/antispambot" target="_blank"><code>antispambot()</code></a> function of WordPress. Notice: be carefull with this option when using email addresses on form fields, please <a href="http://wordpress.org/extend/plugins/email-encoder-bundle/faq/" target="_blank">check the FAQ</a> for more info. Notice: only works for text widgets! Notice: shortcodes still work on these posts. Other Plugins Please rate this plugin! Powered by Pretty save method using JavaScipt's escape function. Protect Email Addresses Protect emails in RSS feeds Protect mailto links, like f.e. <code>&lt;a href="info@myemail.com"&gt;My Email&lt;/a&gt;</code> Protected Mail Link (code): Quick Start RSS Settings Recommended, the savest method using a rot13 method in JavaScript. Remove all shortcodes from the RSS feeds. Remove shortcodes from RSS feeds Replace emails in RSS feeds. Replace plain email addresses to protected mailto links. Replace prefilled email addresses in input fields. Report a problem Save Changes Seperate Id's by comma, f.e.: 2, 7, 13, 32. Set <code>&lt;noscript&gt;</code> text Set protection text in RSS feeds Settings Settings saved. Shortcodes Show "powered by" Show "successfully encoded" text for all encoded content, only when logged in as admin user. Show as main menu item. Show the "powered by"-link on bottom of the encoder form Successfully Encoded Successfully Encoded (this is a check and only visible when logged in as admin) Support Template Functions This way you can check if emails are really encoded on your site. Use deprecated names Use shortcodes in widgets Used as <code>&lt;noscript&gt;</code> fallback for JavaScrip methods. Used as replacement for email addresses in RSS feeds. Warning: "WP Mailto Links"-plugin is also activated, which could cause conflicts. You can also put the encoder form on your site by using the shortcode <code>[eeb_form]</code> or the template function <code>eeb_form()</code>. Project-Id-Version: email-encoder-bundle
POT-Creation-Date: 2015-06-22 15:26+0100
PO-Revision-Date: 2015-06-22 18:12+0100
Last-Translator: Victor <info@freelancephp.net>
Language-Team:  <info@freelancephp.net>
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: Poedit 1.6.3
X-Poedit-Basepath: .
Plural-Forms: nplurals=2; plural=(n != 1);
X-Poedit-KeywordsList: __;_e
Language: nl_NL
X-Poedit-SearchPath-0: ..
  - Aanbevolen! <h3><img src="%s" width="16" height="16" /> %s - versie %s</h3><p>De plugin werkt out-of-the-box. Alle mailto links in posts, pagina's, reacties en (tekst) widgets worden beschermd (standaard). <br/>Als je ook gewone email adressen automatisch wilt beschermen, dan moet je de optie aanvinken.</p><img src="%s" width="600" height="273" /> <h3>Action Hooks</h3><h4>eeb_ready</h4><p>Voeg extra code toe bij de initialisatie van de plugin, zoals extra filters voor encoderen.</p><pre><code><&#63;php
add_action('eeb_ready', 'extra_encode_filters');

function extra_encode_filters($eeb_object) {
    add_filter('some_filter', array($eeb_object, 'callback_filter'));
}
&#63;></code></pre> <h3>FAQ</h3><p>Kijk op de <a href="http://wordpress.org/extend/plugins/email-encoder-bundle/faq/" target="_blank">FAQ van de Plugin site</a>. <h3>Filter Hooks</h3><h4>eeb_mailto_regexp</h4><p></p><pre><code><&#63;php
add_filter('eeb_mailto_regexp', 'change_mailto_regexp');

function change_mailto_regexp($regexp) {
    return '-your regular expression-';
}
&#63;></code></pre><h4>eeb_email_regexp</h4><p>De regular expression voor het vinden van email adressen, kun je zelf wijzigen.</p><pre><code><&#63;php
add_filter('eeb_email_regexp', 'change_email_regexp');

function change_email_regexp($regexp) {
    return '-your regular expression-';
}
&#63;></code></pre><h4>eeb_form_content</h4><p>Filter for changing the form layout.</p><pre><code><&#63;php
add_filter('eeb_form_content', 'eeb_form_content', 10, 4);

function eeb_form_content($content, $labels, $show_powered_by, $methods) {
    // add a &lt;div&gt;-wrapper
    return '&lt;div class="form-wrapper"&gt;' . $content . '&lt;/div&gt;';
}
&#63;></code></pre> <h3>Shortcodes</h3><p>Je kunt deze shortcodes gebruiken in een post of pagina.</p><h4>eeb_email</h4><p>Maak een beschermde mailto link:</p><p><code>[eeb_email email="..." display="..."]</code></p><ul><li>"display" is optioneel, anders wordt het emailadres getoond (uiteraard ook beschermd)</li><li>"extra_attrs" is optioneel, bijv: <code>extra_attrs="target='_blank'"</code></li><li>"method" is optioneel, anders wordt de methode gebruikt, die je hebt ingesteld bij de instellingen.</li></ul><h4>eeb_content</h4><p>Bescherm willekeurige tekst:</p><p><code>[eeb_content method="..."]...[/eeb_content]</code></p><ul><li>"method" is optioneel, anders wordt de methode gebruikt, die je hebt ingesteld bij de instellingen.</li></ul><h4>eeb_form</h4><p>Maak een encodeer formulier:</p><p><code>[eeb_form]</code></p> <h3>Template Functies</h3><h4>eeb_email()</h4><p>Maak een beschermde mailto link:</p><pre><code><&#63;php
if (function_exists('eeb_email')) {
    echo eeb_email('info@somedomain.com');
}
&#63;></code></pre><p>Je kunt enkele optionele parameters toevoegen (in deze volgorde): <code>display</code>, <code>extra_attrs</code>, <code>method</code></p><h4>eeb_content()</h4><p>Bescherm willekeurige tekst:</p><pre><code><&#63;php
if (function_exists('eeb_content')) {
    echo eeb_content('Encode this text');
}
&#63;></code></pre><p>Je kunt een extra optionele parameter toevoegen: <code>method</code></p><h4>eeb_email_filter()</h4><p>Filter de content en bescherm alle email adressen of mailto links:</p><pre><code><&#63;php
if (function_exists('eeb_email_filter')) {
    echo eeb_email_filter('Some content with email like info@somedomein.com or a mailto link');
}
&#63;></code></pre><p>Je kunt enkele optionele parameters toevoegen (in deze volgorde): <code>enc_tags</code>, <code>enc_mailtos</code>, <code>enc_plain_emails</code>, <code>enc_input_fields</code></p><h4>eeb_form()</h4><p>Maak een encodeer formulier:</p><pre><code><&#63;php
if (function_exists('eeb_form')) {
    echo eeb_form();
}
&#63;></code></pre> <h4>Over de auteur</h4><ul><li><a href="http://www.freelancephp.net/" target="_blank">FreelancePHP.net</a></li><li><a href="http://www.freelancephp.net/contact/" target="_blank">Contact</a></li></ul> <p>Waarschuwing - Deze plugin <strong>%s</strong> vereist PHP 5.2.4+ en WP 3.6+.  Upgrade PHP en/of WordPress versie.<br/>Deze waarschuwing verdwijnt zodra u de plugin uitschakelt.</p> Action Hook Activeer Voeg een CSS class toe aan de mailto links Aanvullende Instellingen Admin Instellingen Alle reacties Alle posts en pagina's Alle beschermde mailto links krijgen deze class(es). Optioneel, mag ook leeg laten. Alle tekst widgets Alle widgets (maakt gebruik van de <code>widget_content</code> filter van de Widget Logic plugin) Gebruik ook shortcodes in widgets Toepassen op... Check "Veilig beschermd" Kies admin menu positie Kies een beschermmethode Kies wat te beschermen Maak Beschermde Email Link &gt;&gt; Link Tekst: Do <strong>not</strong> apply protection on posts or pages with the folllowing ID: Documentatie Email Adres: Email Encoder Bundle Email Encoder Formulier Beschermd Encodeer Methode: Posts uitsluiten FAQ Filter Hooks Voor beschermde emails: Voor ander beschermde content: Zoek deze plugin Html Encoderen Met dit formulier kun je handmatig je eigen beschermde mailto links maken. Kopiëer de gegenereerde code en plaats het in je post, pagina of template. JS Escape JS Rot13 Blijf de oude namen voor acties, shortcodes en template functies ondersteunen Mailto Link: Algemene Instellingen Magage externe links op je site: open in een nieuwe window/tab, zet een icoon, voeg  "external" en "nofollow" toe en meer. Manage mailto links op je site en bescherm emails van spambots, zet mail icoon en meer. Niet aanbevolen, equivalent van de  ingebouwde <a href="http://codex.wordpress.org/Function_Reference/antispambot" target="_blank"><code>antispambot()</code></a> functie in WordPress Opmerking: wees voorzichtig met deze optie als je email addressen in formulier velden gebruikt, <a href="http://wordpress.org/extend/plugins/email-encoder-bundle/faq/" target="_blank">check deFAQ</a> voor meer info. Opmerking: werkt alleen voor tekst widgets! Opmerking: shortcodes werken nog steeds voor deze posts. Andere Plugins Laat een review achter! Gemaakt door Redelijk veilige methode, gebruikt de JavaScript escape functie Bescherm Email Adressen Bescherm emails in RSS feeds Bescherm mailto links, zoals bijv. <code>&lt;a href="info@myemail.com"&gt;Mijn Email&lt;/a&gt;</code> Beschermde Email Link (code): Snel Start RSS Instellingen Aanbevolen, de veiligste methode is rot13 met JavaScript Verwijder alle shortcodes uit de RSS feeds Verwijder shortcodes uit RSS feeds Bescherm emails in RSS feeds Maak van email adressen veilige mailto links Bescherm vooringevulde email adressen in formulier velden Meld een probleem Wijzigingen Opgeslagen Scheid Id's met een komma, bijv: 2, 7, 13, 32 Zet  <code>&lt;noscript&gt;</code> tekst Zet de vervangende text voor RSS feeds Instellingen Instellingen opgeslagen. Shortcodes Toon "gemaakt door" Toont "Veilig beschermd" tekst voor alle beschermde content, alleen wanneer je bent ingelogd als admin gebruiker. Toon als hoofdmenu item Toon "gemaakt door"-link onderaan de encodeer formulier Veilig Beschermd Veilig Beschermd (deze check is alleen zichtbaar omdat je bent ingelogd als admin) Ondersteuning Template Functies Op deze manier kun je checken of emails echt beschermd zijn op je site. Gebruik afgeschafte (deprecated) namen Gebruik shortcodes in widgets Gebruikt als <code>&lt;noscript&gt;</code> vangnet voor JavaScrip methoden. Deze tekst wordt gebruikt om te tonen op de plek van de email adressen in RSS feeds Waarschuwing: "WP Mailto Links"-plugin is ook geactiveerd en kan conflicten veroorzaken. Je kunt ook de encodeer formulier op je site plaatsen met behulp van de shortcode <code>[eeb_form]</code> of de template functie <code>eeb_form()</code>. 