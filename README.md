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

## **☁️ Produkční nasazení na Netlify**

Projekt je plně nakonfigurován a optimalizován pro nasazení na bezplatný a rychlý hosting **Netlify** podle zadávací dokumentace.

### **Automatický deploy přes Git (Doporučeno)**

1. Nahrajte tento projekt do svého Git repozitáře (GitHub / GitLab / Bitbucket).  
2. Přihlaste se do administračního panelu **Netlify** (https://app.netlify.com/).  
3. Klikněte na **Add new site** \-\> **Import an existing project**.  
4. Vyberte svůj repozitář.  
5. Nastavení buildu (Build settings):  
   * **Build command:** *ponechte prázdné* (jedná se o statické HTML, které se nesestavuje)  
   * **Publish directory:** . (kořenový adresář, kde leží index.html)  
6. Klikněte na **Deploy site**. Od této chvíle se při každém pushnutí do Git větve web automaticky zaktualizuje.

### **Ruční deploy (Drag & Drop)**

Pokud nepoužíváte Git:

1. Přejděte na https://app.netlify.com/.  
2. Přetáhněte celou složku s projektem (obsahující index.html, složku foto, netlify.toml a README.md) do vyznačeného Drag & Drop boxu na Netlify.

## **⚙️ Netlify Konfigurace a Formuláře**

Projekt je vybaven souborem netlify.toml, který na serveru automaticky nastavuje:

* Kešování statických assetů (obrázků ve složce /foto/) na 1 rok pro bleskové načtení při opakované návštěvě.  
* Základní pravidla přesměrování a SEO indexaci.

## **📄 Licence a autorská práva**

* **Fotografie:** Skutečné realizace Dominika Anděla. Všechna práva vyhrazena.  
* **Ikony:** Font Awesome (Free licence).  
* **Písma:** Google Fonts (OFL \- Open Font License).