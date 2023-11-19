import puppeteer from 'puppeteer';
import fs from 'node:fs';

// Got from the stores modal select that shows up when a
// new browser is opened and the store is not defined yet
const STORES_SELECT_VALUES = {
    // Itapema e Região
    TIJUCAS: 'website_lj9',
    ITAPEMA: 'website_lj9',
    PORTO_BELO: 'website_lj9',

    // Itajaí e Região
    CAMBORIU: 'website_lj5',
    ITAJAI: 'website_lj5',
    BALNEARIO_CAMBORIU: 'website_lj5',

    // Penha e Região
    BARRA_VELHA: 'website_lj23',
    PENHA: 'website_lj23',
    PICARRAS: 'website_lj23',

    FLORIANOPOLIS: 'website_lj47',

    NAVEGANTES: 'website_lj44',
};

const ALL_PAGES = [
    'https://www.superkoch.com.br/carnes',
    'https://www.superkoch.com.br/mercearia',
    'https://www.superkoch.com.br/frios-laticinios',
    'https://www.superkoch.com.br/horta-pomar-granja-floric',
    'https://www.superkoch.com.br/bebidas',
    'https://www.superkoch.com.br/limpeza',
    'https://www.superkoch.com.br/higiene',
    'https://www.superkoch.com.br/outros'
];

const run = async () => {
    const browser = await puppeteer.launch({
        headless: 'new',
        devtools: false,
        defaultViewport: null,
        args: ['--start-maximized']
    });

    const allProducts = {}

    for (const initialPageLink of ALL_PAGES) {
        for (const storeValue of [...new Set(Object.values(STORES_SELECT_VALUES))]) {
            if (!allProducts[storeValue]) {
                allProducts[storeValue] = []
            }

            const products = await scrapeProducts(browser, initialPageLink, storeValue)

            allProducts[storeValue] = [...products, ...allProducts[storeValue]]
        }
    }

    await browser.close();

    fs.writeFileSync(
        'storage/app/scraper/supermercado_koch_products.json',
        JSON.stringify(allProducts, null, 2)
    )
}

async function scrapeProducts(browser, pageLink, storeValue) {
    const allProducts = []
    let currentPageLink = pageLink

    while (true) {
        console.info(`Scraping ${currentPageLink} for store ${storeValue}`)

        const page = await browser.newPage();

        // This is the used by the website to know which store to use
        await page.setCookie({name: 'customer_website', value: storeValue, domain: 'www.superkoch.com.br', path: '/'})

        await page.goto(currentPageLink);

        const products = await page.evaluate(async () => {
            const products = []
            const listContainer = document.querySelector('.products.list.items.product-items')

            for (const item of listContainer.children) {
                const link = item.querySelector('a.product.photo.product-item-photo').href
                const sku = link.split('-').at(-1)

                products.push({
                    name: item.querySelector('a.product-item-link').innerText,
                    price: item.querySelector('span.price').innerText
                        .replace('R$', '')
                        .replace(',', '.')
                        .trim(),
                    picture: item.querySelector('img.product-image-photo').src,
                    link,
                    sku
                })
            }

            return products
        })

        allProducts.push(...products)

        const nextPageLink = await page.evaluate(() => {
            return document.querySelector('a.action.next')?.href
        })

        await page.close()

        if (!nextPageLink) {
            break
        } else {
            currentPageLink = nextPageLink
        }
    }

    return allProducts
}

export default run
