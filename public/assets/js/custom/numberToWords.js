function numberToWords(n) {
  const unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
  const especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISÉIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
  const decenas = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
  const centenas = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

  if (n === 0) return 'CERO';
  if (n === 100) return 'CIEN';

  let texto = '';

  if (n >= 1000) {
    const miles = Math.floor(n / 1000);
    if (miles === 1) texto += 'MIL ';
    else texto += numberToWords(miles) + ' MIL ';
    n %= 1000;
  }

  if (n >= 100) {
    texto += centenas[Math.floor(n / 100)] + ' ';
    n %= 100;
  }

  if (n >= 10 && n < 20) {
    texto += especiales[n - 10];
  } else if (n >= 20 && n < 30) {
    // 🔹 Special case for 21–29
    if (n === 20) texto += 'VEINTE';
    else texto += 'VEINTI' + unidades[n - 20];
  } else if (n >= 30) {
    texto += decenas[Math.floor(n / 10)];
    if (n % 10 !== 0) texto += ' Y ' + unidades[n % 10];
  } else if (n > 0) {
    texto += unidades[n];
  }

  return texto.trim();
}

function sectionToWords(num) {
  if (num === 0) return '';
  if (num < 1000) return numeroATexto(num);

  let texto = '';
  if (num < 1000000) {
    const miles = Math.floor(num / 1000);
    const resto = num % 1000;
    texto += (miles === 1 ? 'MIL' : numeroATexto(miles) + ' MIL');
    if (resto > 0) texto += ' ' + numeroATexto(resto);
  } else if (num < 1000000000) {
    const millones = Math.floor(num / 1000000);
    const resto = num % 1000000;
    texto += (millones === 1 ? 'UN MILLÓN' : numeroATexto(millones) + ' MILLONES');
    if (resto > 0) texto += ' ' + sectionToWords(resto);
  } else {
    texto = 'NÚMERO DEMASIADO GRANDE';
  }
  return texto.trim();
}

function convertToDollars(numero) {
  const entero = Math.floor(numero);
  const centavos = Math.round((numero - entero) * 100);

  const textoEntero = sectionToWords(entero);
  const textoCentavos = centavos > 0 ? ` CON ${sectionToWords(centavos)} CENTAVOS` : '';

  const montoFormateado = numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

  return `${textoEntero} DÓLARES${textoCentavos} DE LOS ESTADOS UNIDOS DE AMÉRICA (US $${montoFormateado}).`;
}

function getIncomeTax(salary, netSalary) {

  let porcentage = 0;
  let excess = 0;
  let fixedFee = 0;

  if(salary >= 550.01 && salary <= 895.24) {
    porcentage = 0.10;
    excess = 550.00;
    fixedFee = 17.67;
  } else if(salary >= 895.25 && salary <= 2038.10) {
    porcentage = 0.20;
    excess = 895.24;
    fixedFee = 60.00;
  } else if(salary >= 2038.11) {
    porcentage = 0.30;
    excess = 2038.10;
    fixedFee = 288.57;
  }

  let incomeTax = ((netSalary - excess) * porcentage) + fixedFee;
  return incomeTax;
}

function dateInWords(date = new Date()) {
  const day = date.getDate();
  const month = date.toLocaleDateString('es-ES', { month: 'long' });
  const year = date.getFullYear();

  // Use your existing numberToWords() function
  return `${numberToWords(day).toLowerCase()} días del mes de ${month} de ${numberToWords(year).toLowerCase()}`;
}

function hiredDateInWords(date = new Date()) {
  const day = date.getDate();
  const month = date.toLocaleDateString('es-ES', { month: 'long' });
  const year = date.getFullYear();

  // Use your existing numberToWords() function
  return `${numberToWords(day).toLowerCase()} de ${month} del año ${numberToWords(year).toLowerCase()}`;
}