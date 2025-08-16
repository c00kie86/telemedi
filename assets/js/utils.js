export const toYYYYMMDD = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
};

export const subDays = (date, days) => {
    const result = new Date(date);
    result.setDate(date.getDate() - days);
    return result;
};