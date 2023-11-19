import fs from "node:fs/promises";
import axios from 'axios'
import jsdom from 'jsdom'

const MARKETS = [
    {
        id: 'loja05',
        baseUrl: 'https://loja05.bistek.com.br',
        name: 'Lages',
    },
    {
        id: 'loja16',
        baseUrl: 'https://loja16.bistek.com.br',
        name: 'São José',
    },
    {
        id: 'loja07',
        baseUrl: 'https://loja07.bistek.com.br',
        name: 'Brusque',
    },
    {
        id: 'loja10',
        baseUrl: 'https://loja10.bistek.com.br',
        name: 'Criciúma',
    },
    {
        id: 'loja17',
        baseUrl: 'https://loja17.bistek.com.br',
        name: 'Blumenau',
    },
    {
        id: 'loja18',
        baseUrl: 'https://loja18.bistek.com.br',
        name: 'Itajaí',
    },
    {
        id: 'loja20',
        baseUrl: 'https://loja20.bistek.com.br',
        name: 'Palhoça',
    },
    {
        id: 'bistek',
        baseUrl: 'https://www.bistek.com.br',
        name: 'Florianópolis',
    }
]

const PAGE_PATHS = [
    '/bazar.html',
    '/bebes.html',
    '/bebidas.html',
    '/carnes.html',
    '/floricultura.html',
    '/frios.html',
    '/higiene-e-beleza.html',
    '/hortifruti.html',
    '/limpeza.html',
    '/mercearia.html',
    '/padaria.html',
    '/pet-shop.html',
    '/saudabilidade.html',
]

const PRODUCTS_PER_PAGE = 36

const run = async () => {
    for (const market of MARKETS) {
        console.info(`Starting scraping ${market.name}`)

        const promises = []

        for (const pagePath of PAGE_PATHS) {
            promises.push(scrapeProducts(market, pagePath))
        }

        await Promise.all(promises)

        console.info(`Finished scraping ${market.name}`)
    }
}

async function scrapeProducts(market, pagePath) {
    const pageLink = market.baseUrl + pagePath

    const pagesCount = await getPagesCount(pageLink)

    const products = []
    let currentPage = 1

    while (currentPage <= pagesCount) {
        const pageProducts = await scrapePageProducts(pageLink, pagesCount, currentPage)
        products.push(...pageProducts)
        currentPage++
    }

    const fileName = market.id + pagePath.replace('.html', '').replace('/', '-')

    await fs.writeFile(`storage/app/scraper/bistek/${fileName}.json`, JSON.stringify(products, null, 2))
}

async function scrapePageProducts(pageLink, totalPages, page) {
    console.info(`Scraping ${pageLink} page ${page}/${totalPages}`)

    const response = await axios.get(pageLink, {
        params: {
            p: page,
            product_list_limit: PRODUCTS_PER_PAGE,
        }
    })

    const dom = new jsdom.JSDOM(response.data)
    const document = dom.window.document
    const items = document.querySelectorAll('.item.product.product-item')

    const products = []
    for (const item of items) {
        products.push({
            name: item.querySelector('a.product-item-link')?.innerHTML?.trim(),

            price: item.querySelector('.price-wrapper').getAttribute('data-price-amount'),

            picture: item.querySelector('img.product-image-photo').src,

            link: item.querySelector('a.product.photo.product-item-photo').href,

            sku: item.querySelector('.price-box.price-final_price').getAttribute('data-product-id'),
        })
    }

    return products
}

async function getPagesCount(pageLink) {
    const response = await axios.get(pageLink, {params: {product_list_limit: 12}})
    const dom = new jsdom.JSDOM(response.data)
    const document = dom.window.document

    const toolbar = document.querySelector('#toolbar-amount')

    let child

    if (toolbar.children.length === 1) {
        child = toolbar.children[0]
    } else {
        child = toolbar.children[1]
    }

    const total = parseInt(child.innerHTML.trim())

    return Math.ceil(total / PRODUCTS_PER_PAGE)
}

export default run
