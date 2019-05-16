import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { StatelistComponent } from './statelist.component';

describe('StatelistComponent', () => {
  let component: StatelistComponent;
  let fixture: ComponentFixture<StatelistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StatelistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StatelistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
