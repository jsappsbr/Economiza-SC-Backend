import axios from 'axios'
import fs from 'node:fs'

// https://www.deliveryfort.com.br/api/catalog_system/pub/products/search/?fq=productId:656070

// const batchSize = 100
// const allProducts = []
//
// let currentId = 500_000
//
// while (currentId < 600_000) {
//     console.log(`Scraping ${currentId}`)
//
//     const fq = Array.from({length: batchSize}, (v, k) => k + currentId)
//         .map(i => `productId:${i}`)
//         .join(',')
//
//     const url = `https://www.deliveryfort.com.br/api/catalog_system/pub/products/search/?fq=${fq}`
//
//     console.log(url)
//
//     const response = await axios.get(url)
//     const products = response.data
//
//     allProducts.push(...products)
//
//     currentId += batchSize
// }
//
// fs.writeFileSync('resources/js/scraper/testfortAtacadista.json', JSON.stringify(allProducts, null, 2))
//
//
// const url = '\n' +
//     'https://www.deliveryfort.com.br/api/catalog_system/pub/products/search/?fq=productId:297305,productId:2710293,productId:2507129,productId:1904418,productId:711357,productId:700703,productId:671711,productId:348457,productId:333069,productId:127019,productId:125083,productId:125075,productId:118877,productId:73318,productId:2845792,productId:2829738,productId:2778629,productId:2769611,productId:2751968,productId:2737230,productId:2691949,productId:2634716,productId:2634708,productId:2604337,productId:2522977,productId:2346591,productId:1697099,productId:1608096,productId:1558234,productId:1430831,productId:1286250,productId:1286226&sc=6'
//
// console.log(url)
//
// const response = await axios.get(url)
// const products = response.data
//
// console.log(products)
