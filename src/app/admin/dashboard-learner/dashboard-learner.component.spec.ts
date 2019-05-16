import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardLearnerComponent } from './dashboard-learner.component';

describe('DashboardLearnerComponent', () => {
  let component: DashboardLearnerComponent;
  let fixture: ComponentFixture<DashboardLearnerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DashboardLearnerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardLearnerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
