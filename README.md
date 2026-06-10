# **Dominik Anděl \- Stavební & malířské práce (Beroun)**

Tento repozitář obsahuje kompletní zdrojové kódy pro moderní, plně responzivní a vysoce přístupný jednostránkový web pro stavební a malířské práce Dominika Anděla. Web je přizpůsobený pro starší cílovou skupinu a optimalizovaný pro snadnou správu, rozvoj a bleskové načítání.

## **🚀 Rychlé spuštění v lokálním prostředí**

Pro spuštění webu na vašem počítači nepotřebujete žádné složité frameworky. Projekt je postaven jako čistá statická stránka (HTML5, Tailwind CSS z CDN a JavaScript).

### **Možnost 1: Spuštění přes Live Server (Doporučeno ve VS Code)**

1. Otevřete složku s projektem ve VS Code.  
2. Nainstalujte rozšíření **Live Server** (od Ritwick Dey).  
3. Klikněte na tlačítko **Go Live** v pravém dolním rohu VS Code.

### **Možnost 2: Spuštění pomocí Node.js (Static Server)**

Pokud máte nainstalovaný Node.js, můžete projekt lokálně spustit jedním z těchto jednoduchých příkazů v terminálu:

\# Spuštění pomocí npx (není potřeba nic instalovat globálně)  
npx serve .

## **🛠️ Build a optimalizace**

Projekt využívá **Tailwind CSS** přímo z optimalizované CDN s konfiguračním skriptem v hlavičce.

* **Zdrojové soubory:** Všechny fotky jsou umístěny ve složce /foto/ (cesta /foto/\[nazev-fotky\].jpg).  
* **Ikony:** Jsou načítány z Font Awesome 6 CDN.  
* **Písma:** Používá se Google Font *Plus Jakarta Sans*, optimalizovaný pro skvělou čitelnost.

## **☁️ Nasazení webu**

Projekt je připravený jako jednoduchý web pro běžný hosting s podporou PHP. HTML, fotky a statické soubory fungují i na čistě statickém hostingu, ale kontaktní formulář potřebuje PHP soubor `odeslat.php`.

### **Dočasné nasazení na Vercel**

Vercel může sloužit jako dočasný náhled statické části webu. Bez serverless úpravy ale nespustí PHP, takže kontaktní formulář přes `odeslat.php` začne fungovat až na hostingu s podporou PHP.

### **Běžný hosting s PHP**

1. Nahrajte obsah projektu do kořenové složky webu, obvykle `public_html`, `www` nebo `htdocs`.
2. Ověřte, že hosting podporuje PHP a funkci `mail()`, případně SMTP odesílání podle pravidel hostingu.
3. V souboru `odeslat.php` nastavte cílový e-mail v konstantě `CILOVY_EMAIL`.
4. Po nahrání otestujte kontaktní formulář a zkontrolujte doručení e-mailu i spam složku.

## **⚙️ Konfigurace hostingu**

Projekt obsahuje `.htaccess` pro Apache hosting. Nastavuje čistší URL, přesměrování non-WWW na WWW, vlastní 404 stránku, bezpečnostní hlavičky a cachování obrázků.

## **📄 Licence a autorská práva**

* **Fotografie:** Skutečné realizace Dominika Anděla. Všechna práva vyhrazena.  
* **Ikony:** Font Awesome (Free licence).  
* **Písma:** Google Fonts (OFL \- Open Font License).
