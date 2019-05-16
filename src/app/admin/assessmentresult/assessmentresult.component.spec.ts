import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AssessmentresultComponent } from './assessmentresult.component';

describe('AssessmentresultComponent', () => {
  let component: AssessmentresultComponent;
  let fixture: ComponentFixture<AssessmentresultComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AssessmentresultComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AssessmentresultComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
