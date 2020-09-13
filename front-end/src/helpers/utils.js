export const formatTimeToSeconds = (timestr) => {
    if ((timestr.includes('pm') && (timestr.split(':')[0] !== '12')) || (timestr.includes('am') && (timestr.split(':')[0] === '12'))) {
        let aux = timestr.split(":");
        aux[0] = (parseInt(aux[0]) + 12).toString()
        timestr = aux.join(':')
    }
    timestr = timestr.replace('am', '').replace('pm', '')
    let parts = timestr.split(":");
    //console.log({timestr, parts})
    return parseInt((parts[0] * 3600)) //hours
        +
        parseInt((parts[1] * 60)) //minutes
        +
        (parseInt(parts[2]) ? parseInt((parts[2])) : 0); //seconds
}

export const formatCurrency = value => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)

export const getOnlyDate = value => ((new Date(value)).toLocaleString()).split(' ')[0]