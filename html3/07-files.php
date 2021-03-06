<?php if ( file_exists("../booktop.php") ) {
  require_once "../booktop.php";
  ob_start();
}?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="" xml:lang="">
<head>
  <meta charset="utf-8" />
  <meta name="generator" content="pandoc" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title>-</title>
  <style>
    code{white-space: pre-wrap;}
    span.smallcaps{font-variant: small-caps;}
    span.underline{text-decoration: underline;}
    div.column{display: inline-block; vertical-align: top; width: 50%;}
    div.hanging-indent{margin-left: 1.5em; text-indent: -1.5em;}
    ul.task-list{list-style: none;}
  </style>
  <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
  <![endif]-->
</head>
<body>
<h1 id="archivos">Archivos</h1>
<p> </p>
<h2 id="persistencia">Persistencia</h2>
<p> </p>
<p>Hasta ahora, hemos aprendido cómo escribir programas y comunicar nuestras intenciones a la <em>Unidad Central de Procesamiento</em> utilizando ejecuciones condicionales, funciones, e iteraciones. Hemos aprendido como crear y usar estructuras de datos en la <em>Memoria Principal</em>. La CPU y la memoria son los lugares donde nuestro software funciona y se ejecuta. Es donde toda la <em>inteligencia</em> ocurre.</p>
<p>Pero si recuerdas nuestras discusiones de arquitectura de hardware, una vez que la corriente se interrumpe, cualquier cosa almacenada ya sea en la CPU o en la memoria es eliminada. Así que hasta ahora nuestros programas han sido sólo una diversión pasajera para aprender Python.</p>
<figure>
<img src="../images/arch.svg" alt="" /><figcaption>Memoria Secundaria</figcaption>
</figure>
<p>En este capítulo, vamos a comenzar a trabajar con <em>Memoria Secundaria</em> (o archivos). La memoria secundaria no es eliminada cuando apagamos una computadora. Incluso, en el caso de una memoria USB, los datos que escribimos desde nuestros programas pueden ser retirados del sistema y transportados a otro sistema.</p>
<p>Nos vamos a enfocar principalmente en leer y escribir archivos como los que creamos en un editor de texto. Más adelante veremos cómo trabajar con archivos de bases de datos, que son archivos binarios diseñados específicamente para ser leídos y escritos a través de software para manejo de bases de datos.</p>
<h2 id="abrir-archivos">Abrir archivos</h2>
<p>  </p>
<p>Cuando queremos abrir o escribir un archivo (digamos, en el disco duro), primero debemos <em>abrir</em> el archivo. Al abrir el archivo nos comunicamos con el sistema operativo, el cual sabe dónde están almacenados los datos de cada archivo. Cuando abres un archivo, le estás pidiendo al sistema operativo que encuentre el archivo por su nombre y se asegure de que existe. En este ejemplo, abrimos el archivo <em>mbox.txt</em>, el cual debería estar almacenado en el mismo directorio en que estás localizado cuando inicias Python. Puedes descargar este archivo desde <a href="http://www.py4e.com/code3/mbox.txt">www.py4e.com/code3/mbox.txt</a></p>
<pre class="python"><code>&gt;&gt;&gt; manejador_archivo = open(&#39;mbox.txt&#39;)
&gt;&gt;&gt; print(manejador_archivo)
&lt;_io.TextIOWrapper name=&#39;mbox.txt&#39; mode=&#39;r&#39; encoding=&#39;cp1252&#39;&gt;</code></pre>
<p></p>
<p>Si el <code>open</code> es exitoso, el sistema operativo nos devuelve un <em>manejador de archivo</em>. El manejador de archivo no son los datos contenidos en el archivo, sino un “manejador” <em>(handler)</em> que podemos usar para leer los datos. Obtendrás un manejador de archivo si el archivo solicitado existe y si tienes los permisos apropiados para leerlo.</p>
<figure>
<img src="../images/handle.svg" alt="" /><figcaption>Un Manejador de Archivo</figcaption>
</figure>
<p>Si el archivo no existe, <code>open</code> fallará con un mensaje de error y no obtendrás un manejador para acceder al contenido del archivo:</p>
<pre class="python"><code>&gt;&gt;&gt; manejador_archivo = open(&#39;stuff.txt&#39;)
Traceback (most recent call last):
File &quot;&lt;stdin&gt;&quot;, line 1, in &lt;module&gt;
FileNotFoundError: [Errno 2] No such file or directory: &#39;stuff.txt&#39;</code></pre>
<p>Más adelante vamos a utilizar <code>try</code> y <code>except</code> para controlar de mejor manera la situación donde tratamos de abrir un archivo que no existe.</p>
<h2 id="archivos-de-texto-y-líneas">Archivos de texto y líneas</h2>
<p>Un archivo de texto puede ser considerado como una secuencia de líneas, así como una cadena de Python puede ser considerada como una secuencia de caracteres. Por ejemplo, este es un ejemplo de un archivo de texto que registra la actividad de correos de varias personas en un equipo de desarrollo de un proyecto de código abierto (open source):</p>
<pre><code>From stephen.marquard@uct.ac.za Sat Jan  5 09:14:16 2008
Return-Path: &lt;postmaster@collab.sakaiproject.org&gt;
Date: Sat, 5 Jan 2008 09:12:18 -0500
To: source@collab.sakaiproject.org
From: stephen.marquard@uct.ac.za
Subject: [sakai] svn commit: r39772 - content/branches/
Details: http://source.sakaiproject.org/viewsvn/?view=rev&amp;rev=39772
...</code></pre>
<p>El archivo completo de interacciones por correo está disponible en</p>
<p><a href="http://www.py4e.com/code3/mbox.txt">www.py4e.com/code3/mbox.txt</a></p>
<p>y una versión reducida del archivo está disponible en</p>
<p><a href="http://www.py4e.com/code3/mbox-short.txt">www.py4e.com/code3/mbox-short.txt</a></p>
<p>Esos archivos están en un formato estándar para un archivo que contiene múltiples mensajes de correo. Las líneas que comienzan con “From” separan los mensajes y las líneas que comienzan con “From:” son parte de esos mensajes. Para más información acerca del formato mbox, consulta</p>
<p><a href="https://es.wikipedia.org/wiki/Mbox" class="uri">https://es.wikipedia.org/wiki/Mbox</a>.</p>
<p>Para separar el archivo en líneas, hay un carácter especial que representa el “final de una línea” llamado <em>salto de línea</em>.</p>
<p></p>
<p>En Python, representamos el <em>salto de línea</em> como una barra invertida-n en las cadenas. Incluso aunque esto parezca dos caracteres, realmente es un solo carácter. Cuando vemos la variable interactuando con el intérprete, este nos muestra el <code>\n</code> en la cadena, pero cuando usamos <code>print</code> para mostrar la cadena, vemos la cadena separada en dos líneas debido al salto de línea.</p>
<pre class="python"><code>&gt;&gt;&gt; cosa = &#39;Hola\nMundo!&#39;
&gt;&gt;&gt; cosa
&#39;Hola\nMundo!&#39;
&gt;&gt;&gt; print(cosa)
Hola
Mundo!
&gt;&gt;&gt; cosa = &#39;X\nY&#39;
&gt;&gt;&gt; print(cosa)
X
Y
&gt;&gt;&gt; len(cosa)
3</code></pre>
<p>También puedes ver que el tamaño de la cadena <code>X\nY</code> es <em>tres</em> caracteres debido a que el separador de línea es un solo carácter.</p>
<p>Por tanto, cuando vemos las líneas en un archivo, necesitamos <em>imaginar</em> que ahí hay un carácter invisible llamado separador de línea al final de cada línea, el cual marca el final de la misma.</p>
<p>De modo que el separador de línea separa los caracteres del archivo en líneas.</p>
<h2 id="lectura-de-archivos">Lectura de archivos</h2>
<p> </p>
<p>Aunque el <em>manejador de archivo</em> no contiene los datos de un archivo, es bastante fácil utilizarlo en un bucle <code>for</code> para leer a través del archivo y contar cada una de sus líneas:</p>
<pre class="python"><code>man_archivo = open(&#39;mbox-short.txt&#39;)
contador = 0
for linea in man_archivo:
    contador = contador + 1
print(&#39;Contador de líneas:&#39;, contador)

# Código: https://es.py4e.com/code3/open.py</code></pre>
<p>Podemos usar el manejador de archivos como una secuencia en nuestro bucle <code>for</code>. Nuestro bucle <code>for</code> simplemente cuenta el número de líneas en el archivo y las imprime. La traducción aproximada de ese bucle al español es, “para cada línea en el archivo representado por el manejador de archivo, suma uno a la variable <code>count</code>.”</p>
<p>La razón por la cual la función <code>open</code> no lee el archivo completo es porque el archivo puede ser muy grande, incluso con muchos gigabytes de datos. La sentencia <code>open</code> emplea la misma cantidad de tiempo sin importar el tamaño del archivo. De hecho, es el bucle <code>for</code> el que hace que los datos sean leídos desde el archivo.</p>
<p>Cuando el archivo es leído usando un bucle <code>for</code> de esta manera, Python se encarga de dividir los datos del archivo en líneas separadas utilizando el separador de línea. Python lee cada línea hasta el separador e incluye el separador como el último carácter en la variable <code>line</code> para cada iteración del bucle <code>for</code>.</p>
<p>Debido a que el bucle <code>for</code> lee los datos línea a línea, éste puede leer eficientemente y contar las líneas en archivos muy grandes sin quedarse sin memoria principal para almacenar los datos. El programa previo puede contar las líneas de cualquier tamaño de archivo utilizando poca memoria, puesto que cada línea es leída, contada, y después descartada.</p>
<p>Si sabes que el archivo es relativamente pequeño comparado al tamaño de tu memoria principal, puedes leer el archivo completo en una sola cadena utilizando el método <code>read</code> en el manejador de archivos.</p>
<pre class="python"><code>&gt;&gt;&gt; manejador_archivo = open(&#39;mbox-short.txt&#39;)
&gt;&gt;&gt; inp = manejador_archivo.read()
&gt;&gt;&gt; print(len(inp))
94626
&gt;&gt;&gt; print(inp[:20])
From stephen.marquar</code></pre>
<p>En este ejemplo, el contenido completo (todos los 94626 caracteres) del archivo <em>mbox-short.txt</em> son leídos directamente en la variable <code>inp</code>. Utilizamos el troceado de cadenas para imprimir los primeros 20 caracteres de la cadena de datos almacenada en <code>inp</code>.</p>
<p>Cuando el archivo es leído de esta forma, todos los caracteres incluyendo los saltos de línea son una cadena gigante en la variable <code>inp</code>. Es una buena idea almacenar la salida de <code>read</code> como una variable porque cada llamada a <code>read</code> vacía el contenido por completo:</p>
<pre class="python"><code>&gt;&gt;&gt; manejador = open(&#39;mbox-short.txt&#39;)
&gt;&gt;&gt; print(len(manejador.read()))
94626
&gt;&gt;&gt; print(len(manejador.read()))
0</code></pre>
<p>Recuerda que esta forma de la función <code>open</code> solo debe ser utilizada si los datos del archivo son apropiados para la memoria principal del sistema. Si el archivo es muy grande para caber en la memoria principal, deberías escribir tu programa para leer el archivo en bloques utilizando un bucle <code>for</code> o <code>while</code>.</p>
<h2 id="búsqueda-a-través-de-un-archivo">Búsqueda a través de un archivo</h2>
<p>Cuando buscas a través de los datos de un archivo, un patrón muy común es leer el archivo, ignorar la mayoría de las líneas y solamente procesar líneas que cumplan con una condición particular. Podemos combinar el patrón de leer un archivo con métodos de cadenas para construir mecanismos de búsqueda sencillos.</p>
<p> </p>
<p>Por ejemplo, si queremos leer un archivo y solamente imprimir las líneas que comienzan con el prefijo “From:”, podríamos usar el método de cadenas <em>startswith</em> para seleccionar solo aquellas líneas con el prefijo deseado:</p>
<pre class="python"><code>man_a = open(&#39;mbox-short.txt&#39;)
contador = 0
for linea in man_a:
    if linea.startswith(&#39;From:&#39;):
        print(linea)

# Código: https://es.py4e.com/code3/search1.py</code></pre>
<p>Cuando este programa se ejecuta, obtenemos la siguiente salida:</p>
<pre><code>From: stephen.marquard@uct.ac.za

From: louis@media.berkeley.edu

From: zqian@umich.edu

From: rjlowe@iupui.edu
...</code></pre>
<p>La salida parece correcta puesto que las líneas que estamos buscando son aquellas que comienzan con “From:”, pero ¿por qué estamos viendo las líneas vacías extras? Esto es debido al carácter invisible <em>salto de línea</em>. Cada una de las líneas leídas termina con un salto de línea, así que la sentencia <code>print</code> imprime la cadena almacenada en la variable <em>line</em>, la cual incluye ese salto de línea, y después <code>print</code> agrega <em>otro</em> salto de línea, resultando en el efecto de doble salto de línea que observamos.</p>
<p>Podemos usar troceado de líneas para imprimir todos los caracteres excepto el último, pero una forma más sencilla es usar el método <em>rstrip</em>, el cual elimina los espacios en blanco del lado derecho de una cadena, tal como:</p>
<pre class="python"><code>man_a = open(&#39;mbox-short.txt&#39;)
for linea in man_a:
    linea = linea.rstrip()
    if linea.startswith(&#39;From:&#39;):
        print(linea)

# Código: https://es.py4e.com/code3/search2.py</code></pre>
<p>Cuando este programa se ejecuta, obtenemos lo siguiente:</p>
<pre><code>From: stephen.marquard@uct.ac.za
From: louis@media.berkeley.edu
From: zqian@umich.edu
From: rjlowe@iupui.edu
From: zqian@umich.edu
From: rjlowe@iupui.edu
From: cwen@iupui.edu
...</code></pre>
<p>A medida que tus programas de procesamiento de archivos se vuelven más complicados, quizá quieras estructurar tus bucles de búsqueda utilizando <code>continue</code>. La idea básica de un bucle de búsqueda es que estás buscando líneas “interesantes” e ignorando líneas “no interesantes”. Y cuando encontramos una línea interesante, hacemos algo con ella.</p>
<p>Podemos estructurar el bucle para seguir el patrón de ignorar las líneas no interesantes así:</p>
<pre class="python"><code>man_a = open(&#39;mbox-short.txt&#39;)
for linea in man_a:
    linea = linea.rstrip()
    # Ignorar &#39;líneas que no nos interesan&#39;
    if not linea.startswith(&#39;From:&#39;):
        continue
    # Procesar la línea que nos &#39;interesa&#39;
    print(linea)

# Código: https://es.py4e.com/code3/search3.py</code></pre>
<p>La salida del programa es la misma. En Español, las líneas no interesantes son aquellas que no comienzan con “From:”, así que las saltamos utilizando <code>continue</code>. En cambio las líneas “interesantes” (aquellas que comienzan con “From:”) las procesamos.</p>
<p>Podemos usar el método de cadenas <code>find</code> para simular la función de búsqueda de un editor de texto, que encuentra las líneas donde aparece la cadena de búsqueda en alguna parte. Puesto que <code>find</code> busca cualquier ocurrencia de una cadena dentro de otra y devuelve la posición de esa cadena o -1 si la cadena no fue encontrada, podemos escribir el siguiente bucle para mostrar las líneas que contienen la cadena “<span class="citation" data-cites="uct.ac.za">@uct.ac.za</span>” (es decir, los que vienen de la Universidad de Cape Town en Sudáfrica):</p>
<pre class="python"><code>man_a = open(&#39;mbox-short.txt&#39;)
for linea in man_a:
    linea = linea.rstrip()
    if linea.find(&#39;@uct.ac.za&#39;) == -1: continue
    print(linea)

# Código: https://es.py4e.com/code3/search4.py</code></pre>
<p>Lo cual produce la siguiente salida:</p>
<pre><code>From stephen.marquard@uct.ac.za Sat Jan  5 09:14:16 2008
X-Authentication-Warning: set sender to stephen.marquard@uct.ac.za using -f
From: stephen.marquard@uct.ac.za
Author: stephen.marquard@uct.ac.za
From david.horwitz@uct.ac.za Fri Jan  4 07:02:32 2008
X-Authentication-Warning: set sender to david.horwitz@uct.ac.za using -f
From: david.horwitz@uct.ac.za
Author: david.horwitz@uct.ac.za
...</code></pre>
<p>Aquí utilizamos la forma contraída de la sentencia <code>if</code> donde ponemos el <code>continue</code> en la misma línea que el <code>if</code>. Esta forma contraída del <code>if</code> funciona de la misma manera que si el <code>continue</code> estuviera en la siguiente línea e indentado.</p>
<h2 id="permitiendo-al-usuario-elegir-el-nombre-de-archivo">Permitiendo al usuario elegir el nombre de archivo</h2>
<p>Definitivamente no queremos tener que editar nuestro código Python cada vez que queremos procesar un archivo diferente. Sería más útil pedir al usuario que introduzca el nombre del archivo cada vez que el programa se ejecuta, de modo que pueda usar nuestro programa en diferentes archivos sin tener que cambiar el código.</p>
<p>Esto es sencillo de hacer leyendo el nombre de archivo del usuario utilizando <code>input</code> como se muestra a continuación:</p>
<pre class="python"><code>narchivo = input(&#39;Ingresa un nombre de archivo: &#39;)
man_a = open(narchivo)
contador = 0
for linea in man_a:
    if linea.startswith(&#39;Subject:&#39;):
        contador = contador + 1
print(&#39;Hay&#39;, contador, &#39;líneas de asunto (subject) en&#39;, narchivo)

# Código: https://es.py4e.com/code3/search6.py</code></pre>
<p>Leemos el nombre de archivo del usuario y lo guardamos en una variable llamada <code>fname</code> y abrimos el archivo. Ahora podemos ejecutar el programa repetidamente en diferentes archivos.</p>
<pre><code>python search6.py
Ingresa un nombre de archivo: mbox.txt
Hay 1797 líneas de asunto (subject) en mbox.txt

python search6.py
Ingresa un nombre de archivo: mbox-short.txt
Hay 27 líneas de asunto (subject) en mbox-short.txt</code></pre>
<p>Antes de mirar la siguiente sección, observa el programa anterior y pregúntate a ti mismo, “¿Qué error podría suceder aquí?” o “¿Qué podría nuestro amigable usuario hacer que cause que nuestro pequeño programa termine no exitosamente con un error, haciéndonos ver no-muy-geniales ante los ojos de nuestros usuarios?”</p>
<h2 id="utilizando-try-except-y-open">Utilizando <code>try, except,</code> y <code>open</code></h2>
<p>Te dije que no miraras. Esta es tu última oportunidad.</p>
<p>¿Qué tal si nuestro usuario escribe algo que no es un nombre de archivo?</p>
<pre><code>python search6.py
Ingresa un nombre de archivo: missing.txt
Traceback (most recent call last):
  File &quot;search6.py&quot;, line 2, in &lt;module&gt;
    man_a = open(narchivo)
FileNotFoundError: [Errno 2] No such file or directory: &#39;missing.txt&#39;

python search6.py
Ingresa un nombre de archivo: na na boo boo
Traceback (most recent call last):
  File &quot;search6.py&quot;, line 2, in &lt;module&gt;
    man_a = open(narchivo)
FileNotFoundError: [Errno 2] No such file or directory: &#39;na na boo boo&#39;</code></pre>
<p>No te rías. Los usuarios eventualmente harán cualquier cosa que puedan para estropear tus programas, sea a propósito o sin intenciones maliciosas. De hecho, una parte importante de cualquier equipo de desarrollo de software es una persona o grupo llamado <em>Quality Assurance</em> (Control de Calidad) (o QA en inglés) cuyo trabajo es probar las cosas más locas posibles en un intento de hacer fallar el software que el programador ha creado.</p>
<p> </p>
<p>El equipo de QA (Control de Calidad) es responsable de encontrar los fallos en los programas antes de éstos sean entregados a los usuarios finales, que podrían comprar nuestro software o pagar nuestro salario por escribirlo. Así que el equipo de QA es el mejor amigo de un programador.</p>
<p>     </p>
<p>Ahora que vemos el defecto en el programa, podemos arreglarlo de forma elegante utilizando la estructura <code>try</code>/<code>except</code>. Necesitamos asumir que la llamada a <code>open</code> podría fallar y agregar código de recuperación para ese fallo, así:</p>
<pre class="python"><code>narchivo = input(&#39;Ingresa un nombre de archivo: &#39;)
try:
    man_a = open(narchivo)
except:
    print(&#39;No se puede abrir el archivo:&#39;, narchivo)
    exit()
contador = 0
for linea in man_a:
    if linea.startswith(&#39;Subject:&#39;):
        contador = contador + 1
print(&#39;Hay&#39;, contador, &#39;líneas de asunto (subject) en&#39;, narchivo)

# Código: https://es.py4e.com/code3/search7.py</code></pre>
<p>La función <code>exit</code> termina el programa. Es una función que llamamos que nunca retorna. Ahora cuando nuestro usuario (o el equipo de QA) introduzca algo sin sentido o un nombre de archivo incorrecto, vamos a “capturarlo” y recuperarnos de forma elegante:</p>
<pre><code>python search7.py
Ingresa un nombre de archivo: mbox.txt
Hay 1797 líneas de asunto (subject) en mbox.txt

python search7.py
Ingresa un nombre de archivo: na na boo boo
No se puede abrir el archivo: na na boo boo</code></pre>
<p></p>
<p>Proteger la llamada a <code>open</code> es un buen ejemplo del uso correcto de <code>try</code> y <code>except</code> en un programa de Python. Utilizamos el término “Pythónico” cuando estamos haciendo algo según el “estilo de Python”. Podríamos decir que el ejemplo anterior es una forma Pythónica de abrir un archivo.</p>
<p>Una vez que estés más familiarizado con Python, puedes intercambiar opiniones con otros programadores de Python para decidir cuál de entre dos soluciones equivalentes a un problema es “más Pythónica”. El objetivo de ser “más Pythónico” engloba la noción de que programar es en parte ingeniería y en parte arte. No siempre estamos interesados sólo en hacer que algo funcione, también queremos que nuestra solución sea elegante y que sea apreciada como elegante por nuestros compañeros.</p>
<h2 id="escritura-de-archivos">Escritura de archivos</h2>
<p></p>
<p>Para escribir en un archivo, tienes que abrirlo en modo “w” (de <code>write</code>, escritura) como segundo parámetro:</p>
<pre class="python"><code>&gt;&gt;&gt; fsal = open(&#39;salida.txt&#39;, &#39;w&#39;)
&gt;&gt;&gt; print(fsal)
&lt;_io.TextIOWrapper name=&#39;salida.txt&#39; mode=&#39;w&#39; encoding=&#39;cp1252&#39;&gt;</code></pre>
<p>Si el archivo ya existía previamente, abrirlo en modo de escritura causará que se borre todo el contenido del archivo, así que ¡ten cuidado! Si el archivo no existe, un nuevo archivo es creado.</p>
<p>El método <code>write</code> del manejador de archivos escribe datos dentro del archivo, devolviendo el número de caracteres escritos. El modo de escritura por defecto es texto para escribir (y leer) cadenas.</p>
<pre class="python"><code>&gt;&gt;&gt; linea1 = &quot;Aquí está el zarzo,\n&quot;
&gt;&gt;&gt; fsal.write(linea1)
24</code></pre>
<p></p>
<p>El manejador de archivo mantiene un seguimiento de dónde está, así que si llamas a <code>write</code> de nuevo, éste agrega los nuevos datos al final.</p>
<p>Debemos asegurarnos de gestionar los finales de las líneas conforme vamos escribiendo en el archivo, insertando explícitamente el carácter de salto de línea cuando queremos finalizar una línea. La sentencia <code>print</code> agrega un salto de línea automáticamente, pero el método <code>write</code> no lo agrega de forma automática.</p>
<pre class="python"><code>&gt;&gt;&gt; linea2 = &#39;el símbolo de nuestra tierra.\n&#39;
&gt;&gt;&gt; fsal.write(linea2)
24</code></pre>
<p>Cuando terminas de escribir, tienes que cerrar el archivo para asegurarte que la última parte de los datos es escrita físicamente en el disco duro, de modo que no se pierdan los datos si la corriente eléctrica se interrumpe.</p>
<pre class="python"><code>&gt;&gt;&gt; fsal.close()</code></pre>
<p>Podríamos cerrar los archivos abiertos para lectura también, pero podemos ser menos rigurosos si sólo estamos abriendo unos pocos archivos puesto que Python se asegura de que todos los archivos abiertos sean cerrados cuando termina el programa. En cambio, cuando estamos escribiendo archivos debemos cerrarlos de forma explícita para no dejar nada al azar.</p>
<p> </p>
<h2 id="depuración">Depuración</h2>
<p> </p>
<p>Cuando estás leyendo y escribiendo archivos, puedes tener problemas con los espacios en blanco. Esos errores pueden ser difíciles de depurar debido a que los espacios, tabuladores, y saltos de línea son invisibles normalmente:</p>
<pre class="python"><code>&gt;&gt;&gt; s = &#39;1 2\t 3\n 4&#39;
&gt;&gt;&gt; print(s)
1 2  3
 4</code></pre>
<p>  </p>
<p>La función nativa <code>repr</code> puede ayudarte. Recibe cualquier objeto como argumento y devuelve una representación del objeto como una cadena. En el caso de las cadenas, representa los espacios en blanco con secuencias de barras invertidas:</p>
<pre class="python"><code>&gt;&gt;&gt; print(repr(s))
&#39;1 2\t 3\n 4&#39;</code></pre>
<p>Esto puede ser útil para depurar.</p>
<p>Otro problema que podrías tener es que diferentes sistemas usan diferentes caracteres para indicar el final de una línea. Algunos sistemas usan un salto de línea, representado como <code>\n</code>. Otros usan un carácter de retorno, representado con <code>\r</code>. Otros usan ambos. Si mueves archivos entre diferentes sistemas, esas inconsistencias podrían causarte problemas.</p>
<p></p>
<p>Para la mayoría de los sistemas, hay aplicaciones que convierten de un formato a otro. Puedes encontrarlas (y leer más acerca de esto) en <a href="wikipedia.org/wiki/Newline">wikipedia.org/wiki/Newline</a>. O también, por supuesto, puedes escribir una tu mismo.</p>
<h2 id="glosario">Glosario</h2>
<dl>
<dt>archivo de texto</dt>
<dd>Una secuencia de caracteres almacenados en un dispositivo de almacenamiento permanente como un disco duro.
</dd>
<dt>capturar (catch)</dt>
<dd>Evitar que una excepción haga terminar un programa, usando las sentencias <code>try</code> y <code>except</code>.
</dd>
<dt>control de calidad (QA)</dt>
<dd>Una persona o equipo enfocado en asegurar la calidad en general de un producto. El Control de calidad (QA) es frecuentemente encargado de probar un software y encontrar posibles problemas antes de que el software sea lanzado.
</dd>
<dt>pythónico</dt>
<dd>Una técnica que funciona de forma elegante en Python. “Utilizar try y except es la forma <em>Pythónica</em> de gestionar los archivos inexistentes”.
</dd>
<dt>salto de línea</dt>
<dd>Un carácter especial utilizado en archivos y cadenas para indicar el final de una línea.
</dd>
</dl>
<h2 id="ejercicios">Ejercicios</h2>
<p><strong>Ejercicio 1: Escribe un programa que lea un archivo e imprima su contenido (línea por línea), todo en mayúsculas. Al ejecutar el programa, debería parecerse a esto:</strong></p>
<pre><code>python shout.py
Ingresa un nombre de archivo: mbox-short.txt
FROM STEPHEN.MARQUARD@UCT.AC.ZA SAT JAN  5 09:14:16 2008
RETURN-PATH: &lt;POSTMASTER@COLLAB.SAKAIPROJECT.ORG&gt;
RECEIVED: FROM MURDER (MAIL.UMICH.EDU [141.211.14.90])
     BY FRANKENSTEIN.MAIL.UMICH.EDU (CYRUS V2.3.8) WITH LMTPA;
     SAT, 05 JAN 2008 09:14:16 -0500</code></pre>
<p><strong>Puedes descargar el archivo desde</strong> <a href="http://www.py4e.com/code3/mbox-short.txt">www.py4e.com/code3/mbox-short.txt</a></p>
<p><strong>Ejercicio 2: Escribe un programa que solicite un nombre de archivo y después lea ese archivo buscando las líneas que tengan la siguiente forma:</strong></p>
<pre><code>X-DSPAM-Confidence: 0.8475</code></pre>
<p>**Cuando encuentres una línea que comience con “X-DSPAM-Confidence:” ponla aparte para extraer el número decimal de la línea. Cuenta esas líneas y después calcula el total acumulado de los valores de “spam-confidence”. Cuando llegues al final del archivo, imprime el valor medio de “spam confidence”.</p>
<pre><code>Ingresa un nombre de archivo: mbox.txt
Promedio spam confidence: 0.894128046745

Ingresa un nombre de archivo: mbox-short.txt
Promedio spam confidence: 0.750718518519</code></pre>
<p><strong>Prueba tu programa con los archivos <em>mbox.txt</em> y <em>mbox-short.txt</em>.</strong></p>
<p><strong>Ejercicio 3: Algunas veces cuando los programadores se aburren o quieren divertirse un poco, agregan un inofensivo <em>Huevo de Pascua</em> a su programa. Modifica el programa que pregunta al usuario por el nombre de archivo para que imprima un mensaje divertido cuando el usuario escriba “na na boo boo” como nombre de archivo. El programa debería funcionar normalmente para cualquier archivo que exista o no exista. Aquí está un ejemplo de la ejecución del programa:</strong></p>
<pre><code>python huevo.py
Ingresa un nombre de archivo: mbox.txt
Hay 1797 líneas subject en mbox.txt

python huevo.py
Ingresa un nombre de archivo: inexistente.tyxt
El archivo no puede ser abierto: inexistente.tyxt

python huevo.py
Ingresa un nombre de archivo: na na boo boo
NA NA BOO BOO PARA TI - Te he atrapado!</code></pre>
<p><strong>No te estamos aconsejando poner Huevos de Pascua en tus programas; es sólo un ejercicio.</strong></p>
</body>
</html>
<?php if ( file_exists("../bookfoot.php") ) {
  $HTML_FILE = basename(__FILE__);
  $HTML = ob_get_contents();
  ob_end_clean();
  require_once "../bookfoot.php";
}?>
