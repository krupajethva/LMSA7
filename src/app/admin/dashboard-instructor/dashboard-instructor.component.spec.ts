import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardInstructorComponent } from './dashboard-instructor.component';

describe('DashboardInstructorComponent', () => {
  let component: DashboardInstructorComponent;
  let fixture: ComponentFixture<DashboardInstructorComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DashboardInstructorComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DashboardInstructorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
