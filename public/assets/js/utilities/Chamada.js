function mostrarJustificativa(select) {

    // Busca o campo de texto (input) que está logo ao lado do select
    let inputJustificativa = select.nextElementSibling

    // Se a opção selecionada for 'J' (Justificada), mostra o campo de texto
    if (select.value === 'J') {

        inputJustificativa.style.display = 'block'
        inputJustificativa.required = true // Obriga o professor a digitar o motivo

    } else {

        // Se for P ou F, esconde o campo e limpa o que estava escrito
        inputJustificativa.style.display = 'none'
        inputJustificativa.required = false
        inputJustificativa.value = ''
    }
}


function imprimirChamada(botao) {

    const turma = botao.dataset.turma
    const professor = botao.dataset.professor
    const alunos = JSON.parse(botao.dataset.alunos || '[]')

    const dataHoje = new Date()
    const anoAtual = dataHoje.getFullYear()
    const mesAtual = dataHoje.getMonth()
    const mesAno = dataHoje.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' }).toUpperCase()
    const dataFormatada = dataHoje.toLocaleDateString('pt-BR')

    const diasUteis = []
    const diasNoMes = new Date(anoAtual, mesAtual + 1, 0).getDate()

    for (let i = 1; i <= diasNoMes; i++) {

        const data = new Date(anoAtual, mesAtual, i)

        if (data.getDay() !== 0) diasUteis.push(String(i).padStart(2, '0'))
    }

    let linhasAlunos = ''

    alunos.forEach((aluno, index) => {

        linhasAlunos += `
            <tr>
                <td class="col-num">${String(index + 1).padStart(2, '0')}</td>
                <td class="col-nome">${aluno.nome}</td>
                ${diasUteis.map(() => `<td></td>`).join('')}
                <td></td>
            </tr>
        `
    })

    const html = `
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Diário de Classe - ${turma}</title>
            <style>
                @page { size: A4 landscape; margin: 5mm; }
                body { font-family: Arial, sans-serif; color: #000; font-size: 11px; margin: 0; padding: 0; }
                .header-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; border: 2px solid #000; }
                .header-table td { border: 1px solid #000; padding: 6px; vertical-align: middle; }
                .school-info { text-align: left; text-transform: uppercase; font-size: 12px; line-height: 1.4; }
                .meta-info { font-size: 11px; text-transform: uppercase; }
                .titulo-diario { text-align: center; font-weight: bold; font-size: 13px; margin-bottom: 10px; text-transform: uppercase; }
                .grid-table { width: 100%; border-collapse: collapse; border: 2px solid #000; }
                .grid-table th, .grid-table td { border: 1px solid #000; padding: 3px 2px; text-align: center; height: 18px; }
                .grid-table th { background-color: #f8f8f8; font-weight: bold; font-size: 10px; }
                .grid-table tr { page-break-inside: avoid; }
                .col-num { width: 25px; }
                .col-nome { text-align: left !important; white-space: nowrap; width: 260px; padding-left: 6px !important; text-transform: uppercase; font-size: 10px; }
                .footer { margin-top: 25px; display: flex; justify-content: space-between; align-items: flex-end; font-size: 11px; page-break-inside: avoid; }
                .assinatura { width: 300px; border-top: 1px solid #000; text-align: center; padding-top: 4px; }
                .logo-box { width: 44px; height: 44px; display: block; margin: 0 auto; }
            </style>
        </head>
        <body>
            <table class="header-table">
                <tr>
                    <td style="width: 70px; text-align: center;"><img class="logo-box" src="/assets/img/cetepi-logo.jpg"></td>
                    <td class="school-info"><strong>Centro Territorial de Educação Profissional de Itaparica</strong><br>Sistema de Gestão Educacional</td>
                    <td class="meta-info" style="width: 320px;"><div><strong>Referência:</strong> ${mesAno}</div><div><strong>Turma:</strong> ${turma}</div><div><strong>Professor(a):</strong> ${professor}</div></td>
                </tr>
            </table>
            <div class="titulo-diario">DIÁRIO DE CLASSE - FREQUÊNCIA</div>
            <table class="grid-table">
                <thead>
                    <tr>
                        <th rowspan="2">Nº</th>
                        <th rowspan="2">Nome do Aluno</th>
                        <th colspan="${diasUteis.length}">Dias Letivos</th>
                        <th rowspan="2">Faltas<br>Mês</th>
                    </tr>
                    <tr>
                        ${diasUteis.map(d => `<th>${d}</th>`).join('')}
                    </tr>
                </thead>
                <tbody>${linhasAlunos}</tbody>
            </table>
            <div class="footer">
                <div>Impresso em: ${dataFormatada}</div>
                <div class="assinatura">Assinatura do(a) Professor(a)</div>
            </div>
            <script>window.onload = () => { window.print() }</script>
        </body>
        </html>
    `

    const janela = window.open('', '_blank')

    if (janela) {

        janela.document.write(html)
        janela.document.close()
    }
}


$(document).on('submit', '#formChamada', function (e) {

    e.preventDefault()

    const form = this
    const formData = new FormData(form)

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => tools.showToast(data.mensagem, data.sucesso ? 'bg-success' : 'bg-danger'))
        .catch(err => {

            console.error(err)
            tools.showToast('Erro ao conectar com o servidor.', 'bg-danger')
        })
})
