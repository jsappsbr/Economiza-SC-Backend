import puppeteer from "puppeteer";
import fs from "node:fs";

const run = async () => {
    const browser = await puppeteer.launch({
        headless: false,
        devtools: false,
        defaultViewport: null,
        args: ['--start-maximized']
    });

    const pageLinks = [
        'https://www.deliveryfort.com.br/alimentacao-saudavel',
        'https://www.deliveryfort.com.br/bebidas',
        'https://www.deliveryfort.com.br/carnes-aves-e-peixes',
        'https://www.deliveryfort.com.br/casa-e-lazer',
        'https://www.deliveryfort.com.br/congelados',
        'https://www.deliveryfort.com.br/food-service',
        'https://www.deliveryfort.com.br/frios-e-laticinios',
        'https://www.deliveryfort.com.br/higiene-e-beleza',
        'https://www.deliveryfort.com.br/hortifruti',
        'https://www.deliveryfort.com.br/infantil',
        'https://www.deliveryfort.com.br/limpeza',
        'https://www.deliveryfort.com.br/mercearia',
        'https://www.deliveryfort.com.br/pet-shop',
    ]

    const allProducts = []

    for (const initialPageLink of pageLinks) {
        const products = await scrapeProducts(browser, initialPageLink)
        allProducts.push(...products)
    }

    fs.writeFileSync('storage/app/scraper/fort_atacadista_products.json', JSON.stringify(allProducts, null, 2))

    await browser.close();
}

async function scrapeProducts(browser, pageLink) {
    console.info(`Scraping ${pageLink}`)

    const allProducts = []

    const page = await browser.newPage();
    await page.goto(pageLink);

    while (true) {
        const products = await page.evaluate(async () => {
            const products = []
            const listContainer = document.querySelector('div.main-shelf.n32colunas').children[0]

            for (const item of listContainer.children) {
                products.push({
                    name: item.querySelector('a.shelf-item__title-link').innerText,

                    price: item.querySelector('span.shelf-item__best-price').children[0].innerText
                        .replace('R$', '')
                        .replace(',', '.')
                        .trim(),

                    picture: item.querySelector('a.shelf-item__img-link').children[0].src,

                    link: item.querySelector('a.shelf-item__img-link').href,

                    sku: item.querySelector('div.shelf-item').getAttribute('data-product-id')
                })
            }

            return products
        })

        allProducts.push(...products)

        await page.evaluate(() => {
            const paginationContainer = document.querySelector('.pagination')
            const nextLink = paginationContainer.querySelector('a.pagination__button--next')
            nextLink.click()
        })


        await page.waitForResponse(response => {
            return response.url().startsWith('https://www.deliveryfort.com.br/buscapagina')
        });

        const hasMoreProducts = await page.evaluate(() => {
            return !document.querySelector('div.main-shelf.n32colunas')
        })

        if (!hasMoreProducts) {
            break
        }

    }

    await page.close()


    return allProducts
}

export default run
