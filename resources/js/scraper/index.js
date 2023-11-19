import {Command} from 'commander';
import runSupermercadoKoch from './supermercadoKoch.js'
import runFortAtacadista from './fortAtacadista.js'
import runBistek from './bistek.js'

const program = new Command();

program.name('scraper')
    .version('0.0.1')

program
    .command('supermercado-koch')
    .description('Scrape products from Supermercado Koch')
    .action(runSupermercadoKoch)

program
    .command('fort-atacadista')
    .description('Scrape products from Fort Atacadista')
    .action(runFortAtacadista)


program
    .command('bistek')
    .description('Scrape products from Bistek')
    .action(runBistek)

program.parse(process.argv)
