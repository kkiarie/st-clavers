<div wire:poll>
   <span style="display:block">Payable : {{number_format($Balance,2)}}  </span>
   <span style="display:block">Paid : {{number_format($Paid,2)}}  </span>
   <span style="display:block">Balance : {{number_format($Balance-$Paid,2)}}  </span>
</div>
