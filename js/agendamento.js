    // Remove todos os caracteres não numéricos, exceto o traço do campo cep
    document.getElementById('cep').addEventListener('input', function(event) {
    let cepValue = event.target.value;    
    cepValue = cepValue.replace(/[^0-9-]/g, '');
    event.target.value = cepValue;
    });


    // Limita a inserção de dados a números positivos
    document.getElementById("quant_resid").addEventListener("input", function () {
        var inputValue = this.value;
        var numericValue = parseInt(inputValue, 10);
        if (numericValue < 1) {
            this.value = "";
        }
    });

    // Limita a entrada de quantidade de resíduos a 5 dígitos
    document.getElementById('quant_resid').addEventListener('input', function(event) {
    let quantResidValue = event.target.value;                        
    if (quantResidValue.length > 5) {
        quantResidValue = quantResidValue.slice(0, 5);
    }
    event.target.value = quantResidValue;
    });


    // Define os valores mínimo e máximo para o campo de data de coleta
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1); 

    const maxDate = new Date();
    maxDate.setFullYear(today.getFullYear() + 1);

    const minDateFormatted = tomorrow.toISOString().split('T')[0];
    const maxDateFormatted = maxDate.toISOString().split('T')[0];

    document.getElementById('data_coleta').setAttribute('min', minDateFormatted);
    document.getElementById('data_coleta').setAttribute('max', maxDateFormatted);  