import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AssessmenttestComponent } from './assessmenttest.component';

describe('AssessmenttestComponent', () => {
  let component: AssessmenttestComponent;
  let fixture: ComponentFixture<AssessmenttestComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AssessmenttestComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AssessmenttestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
