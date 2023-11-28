import {createLogger, format, transports} from "winston";

const logger = createLogger({
    format: format.combine(
        format.timestamp(),
        format.printf(info => {
            let parsedMessage = info.message

            if (typeof info.message === 'object') {
                parsedMessage = JSON.stringify(info.message, null, 1)
            }

            return `[${info.timestamp}] ${info.level}: ${parsedMessage}`
        })
    ),
    transports: [
        new transports.File({filename: 'storage/logs/scraper.log'}),
        new transports.Console(),
    ],
});

export default logger;