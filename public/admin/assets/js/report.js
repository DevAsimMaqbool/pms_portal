const chartLabels = window.chartLabels || [];
const dataset1 = window.dataset1 || [];
const dataset2 = window.dataset2 || [];

function downloadPDF() {
    const element = document.getElementById('report-content');
    const opt = {
        margin: [0.5, 0.5, 0.5, 0.5],
        filename: 'Virtue_Mirror_Report.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
    };
    html2pdf().set(opt).from(element).save();
}