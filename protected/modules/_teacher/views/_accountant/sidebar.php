<li ng-controller="mainAccountantCtrl">
    <a ng-href="#/accountant">
        <i class="fa fa-bar-chart-o fa-fw"></i>Бухгалтер
        <span ng-cloak class="label label-success" ng-if="countOfActualSchemesRequests > 0">{{countOfActualSchemesRequests}}</span>
        <span ng-cloak class="label label-primary" ng-if="countOfActualWrittenAgreementRequests > 0">{{countOfActualWrittenAgreementRequests}}</span>
    </a>
</li>